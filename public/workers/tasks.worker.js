let queryableFunctions = {
  makeRequest: function (method, token, url) {
    if (arguments.length < 3) { throw new TypeError('reply - not enough arguments'); return; }

    const headers = new Headers({
      'X-CSRF-TOKEN': token,
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'application/json'
    })

    const request = new Request(url, {
      method: method,
      headers: headers,
      mode: 'cors',
      cache: 'default'
    })

    fetch(request)
      .then((response) => {
        return response.json()
      }).then((json) => {
        reply('success', json)
      }).catch((error) => {
        throw error
      })
  }
}

function defaultReply(message) {
  // your default PUBLIC function executed only when main page calls the queryableWorker.postMessage() method directly
  // do something
}

function reply() {
  if (arguments.length < 1) { throw new TypeError('reply - not enough arguments'); return; }
  postMessage({ 'queryMethodListener': arguments[0], 'queryMethodArguments': Array.prototype.slice.call(arguments, 1) })
}

onmessage = function(oEvent) {
  if (oEvent.data instanceof Object && oEvent.data.hasOwnProperty('queryMethod') && oEvent.data.hasOwnProperty('queryMethodArguments')) {
    queryableFunctions[oEvent.data.queryMethod].apply(self, oEvent.data.queryMethodArguments)
  } else {
    defaultReply(oEvent.data);
  }
}
