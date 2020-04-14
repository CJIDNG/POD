<?php

namespace App\Http\Controllers;

use App\Dataresource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

class DataresourceController extends Controller
{
  public function __construct() {
    $client = new \Redis();
    $client->connect('127.0.0.1', 6379);
    $pool = new \Cache\Adapter\Redis\RedisCachePool($client);
    $simpleCache = new \Cache\Bridge\SimpleCache\SimpleCacheBridge($pool);

    \PhpOffice\PhpSpreadsheet\Settings::setCache($simpleCache);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(): JsonResponse
  {
    $all = request('all') ?? NULL;
    
    if ($all) {
      $dataresources = Dataresource::all();
    } else {
      $dataresources = Dataresource::orderBy('name')
        ->paginate();
    }
    return response()->json(
      $dataresources, 200
    );
  }

  /**
   * Get a single dataresource or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   */
  public function show($id = null): JsonResponse
  {
    if (Dataresource::all()->pluck('id')->contains($id) || $this->isNewDataresource($id)) {
      if ($this->isNewDataresource($id)) {
        return response()->json([
          'id' => NULL,
        ], 200);
      } else {
        $dataresource = Dataresource::where('id', $id)->with('format.previews')->first();

        if (request('previewData')) {
          $this->getFileData($dataresource->path);
        }

        if ($dataresource) {
          return response()->json($dataresource, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  private function getFileName($path) {
    /**
     * usage of str_replace here is a hack to make 
     * the is_file function in PhpSpreadsheet work as expected
     */
    return Storage::disk('public')->path(\str_replace('storage/', '', $path));
  }

  private function getFileType($inputFileName) {
    return IOFactory::identify($inputFileName);
  }

  private function createReader($inputFileType) {
    $reader = IOFactory::createReader($inputFileType);
    $reader->setReadDataOnly(true);
    return $reader;
  }

  private function getFileData($path) {
    /**
     * probably terrible hacks for time 
     * and memory limit
     */
    // set_time_limit(300);
    // ini_set('memory_limit', '-1');
    $fileData = [];
    $inputFileName = $this->getFileName($path);
    $inputFileType = $this->getFileType($inputFileName);
    $reader = $this->createReader($inputFileType);
    
    /**  Define how many rows we want to read for each "chunk"  **/
    $chunkSize = 2048;
    /**  Create a new Instance of our Read Filter  **/
    $chunkFilter = new \App\Http\Controllers\Helpers\ChunkReadFilter();
    /**  Tell the Reader that we want to use the Read Filter  **/
    $reader->setReadFilter($chunkFilter);
    $spreadsheet = $reader->load($inputFileName);
    $sheetNames = $spreadsheet->getSheetNames();

    $fileData = array();
    /**  Loop to read our worksheet in "chunk size" blocks  **/
    for ($startRow = 2; $startRow <= 65536; $startRow += $chunkSize) {
      /**  Tell the Read Filter which rows we want this iteration  **/
      $chunkFilter->setRows($startRow,$chunkSize);
      /**  Load only the rows that match our filter  **/
      $worksheet = $reader->load($inputFileName)->getActiveSheet();
      // ->getSheetByName($sheetName)

      // dd($spreadsheet->getActiveSheet());
      foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); 
        foreach ($cellIterator as $cell) {
          array_push($fileData, $cell->getValue());
        }
      }
    }

  }

  /**
   * Create or update a dataresource.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'title' => request('title'),
      'description' => request('description'),
      'path' => request('path'),
      'dataformat_id' => $id === 'create' ? $this->getDataformatId(request('path')) : request('dataformat_id'),
      'dataset_id' => request('dataset_id'),
      'downloadable' => request('downloadable'),
      'user_id' => $id === 'create' ? request()->user()->id : request('user_id')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'title' => 'required',
      'description' => 'required',
      'path' => 'required',
      'dataset_id' => 'required',
      'downloadable' => 'required',
      'user_id' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $dataresource = Dataresource::find($id);
    } else {
      if ($dataresource = Dataresource::onlyTrashed()->where('id', $id)->first()) {
        $dataresource->restore();
      } else {
        $dataresource = new Dataresource(['id' => request('id')]);
      }
    }

    $dataresource->fill($data);
    $dataresource->save();

    return response()->json($dataresource->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $dataresource = Dataresource::find($id);

    if ($dataresource) {
      $file = pathinfo(request()->getContent());
      $storagePath = $this->baseStoragePath();
      $explodedPath = \explode('/', $dataresource->path);
      $path = "{$storagePath}/{$explodedPath[count($explodedPath) - 1]}";

      $fileDeleted = Storage::disk(config('data.storage_disk'))->delete($path);

      if ($fileDeleted) {
        $dataresource->delete();
        return response()->json([], 204);
      } else {
        return response()->json([$fileDeleted], 500);
      }
    }
  }

  /**
   * Return true if we're creating a new dataresource.
   *
   * @param string $id
   * @return bool
   */
  private function isNewDataresource(string $id): bool
  {
    return $id === 'create';
  }

  /**
   * Return dataformat id
   * 
   * @param string $path
   * @return int
   */
  private function getDataformatId(string $path): int {
    $explodedPath = explode('/', $path);
    $filename = $explodedPath[count($explodedPath) - 1];
    $explodedFilename = explode('.', $filename);
    $extension = $explodedFilename[count($explodedFilename) - 1];

    return \App\Dataformat::where('extension', $extension)->first()->id;
  }

  public function download($id) {
    // $resource = Dataresource::findOrFail($id);
    // $filepath = \str_replace('storage/', '', $resource->path);

    // return Storage::download($filepath, $resource->title);
    // return Storage::disk('public')->download($filepath, $resource->title);
    return response([], 200);
  }

  /**
   * Return the storage path url.
   *
   * @return string
   */
  private function baseStoragePath(): string
  {
    $currentTenant = new \App\CurrentTenant();
    $platformName = $currentTenant->getPlatform()->name;
    return $currentTenant->getWebsite() ? 
      sprintf('%s', config('data.storage_path')."/${platformName}") :
      sprintf('%s', config('data.storage_path')) ;
  }
}
