<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dataformat extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];
  
  public static function defaultFormats() {
    return [
      [
        'name' => 'comma seperated value',
        'extension' => 'csv',
        'mime_type' => 'text/csv'
      ],
      [
        'name' => 'hypertext markup language',
        'extension' => 'html',
        'mime_type' => 'text/html'
      ],
      [
        'name' => 'microsoft excel spreadsheet',
        'extension' => 'xls',
        'mime_type' => 'application/vnd.ms-excel'
      ],
      [
        'name' => 'javascript object notation',
        'extension' => 'json',
        'mime_type' => 'application/json'
      ],
      [
        'name' => 'javascript excel spreadsheet',
        'extension' => 'xlsx',
        'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
      ],
      [
        'name' => 'microsoft word document',
        'extension' => 'doc',
        'mime_type' => 'application/msword'
      ],
      [
        'name' => 'microsoft word document',
        'extension' => 'docx',
        'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
      ],
      [
        'name' => 'resource description framework',
        'extension' => 'rdf',
        'mime_type' => 'application/rdf+xml'
      ],
      [
        'name' => 'text file',
        'extension' => 'txt',
        'mime_type' => 'text/plain'
      ],
      [
        'name' => 'join photographic experts group',
        'extension' => 'jpg',
        'mime_type' => 'image/jpeg'
      ],
      [
        'name' => 'join photographic experts group',
        'extension' => 'jpeg',
        'mime_type' => 'image/jpeg'
      ],
      [
        'name' => 'portable network graphics',
        'extension' => 'png',
        'mime_type' => 'image/png'
      ],
      [
        'name' => 'graphic interchange format',
        'extension' => 'gif',
        'mime_type' => 'image/gif'
      ],
      [
        'name' => 'portable document format',
        'extension' => 'pdf',
        'mime_type' => 'application/pdf'
      ],
      [
        'name' => 'open document format',
        'extension' => 'odf',
        'mime_type' => 'application/vnd.oasis.opendocument.formula'
      ],
      [
        'name' => 'open document spreadsheet',
        'extension' => 'ods',
        'mime_type' => 'application/vnd.oasis.opendocument.spreadsheet'
      ],
      [
        'name' => 'open document text',
        'extension' => 'odt',
        'mime_type' => 'application/vnd.oasis.opendocument.text'
      ],
      [
        'name' => 'tab seperated values',
        'extension' => 'tsv',
        'mime_type' => 'text/tab-separated-values'
      ],
      [
        'name' => 'table of data seperated by tabs',
        'extension' => 'tab',
        'mime_type' => 'text/tab-separated-values'
      ],
      [
        'name' => 'for representing simple geographical features',
        'extension' => 'geojson',
        'mime_type' => 'application/geo+json'
      ],
      [
        'name' => 'extensible markup language',
        'extension' => 'xml',
        'mime_type' => 'application/xml'
      ],
      [
        'name' => 'archive format',
        'extension' => 'zip',
        'mime_type' => 'application/zip'
      ],
    ];
  }

  public function previews() {
    return $this->belongsToMany(Datavisualisation::class);
  }

  public function resources(): HasMany {
    return $this->hasMany(Dataresource::class, 'dataformat_id');
  }
}
