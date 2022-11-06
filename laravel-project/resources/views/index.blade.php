<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sample illustrating the use of Web Bluetooth / Watch Advertisements.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Web Bluetooth / Watch Advertisements Sample</title>
    <script>
      window.addEventListener('error', function(error) {
        if (ChromeSamples && ChromeSamples.setStatus) {
          console.error(error);
          ChromeSamples.setStatus(error.message + ' (Your browser may not support this feature.)');
          error.preventDefault();
        }
      });
    </script> 
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  </head>

  <body>

<!-- <script>
  if('serviceWorker' in navigator) {
    navigator.serviceWorker.register('service-worker.js');
  }
</script> -->

<script>
  window.addEventListener('DOMContentLoaded', function() {
    const searchParams = new URL(location).searchParams;
    const inputs = Array.from(document.querySelectorAll('input[id]'));

    inputs.forEach(input => {
      if (searchParams.has(input.id)) {
        if (input.type == 'checkbox') {
          input.checked = searchParams.get(input.id);
        } else {
          input.value = searchParams.get(input.id);
          input.blur();
        }
      }
      if (input.type == 'checkbox') {
        input.addEventListener('change', function(event) {
          const newSearchParams = new URL(location).searchParams;
          if (event.target.checked) {
            newSearchParams.set(input.id, event.target.checked);
          } else {
            newSearchParams.delete(input.id);
          }
          history.replaceState({}, '', Array.from(newSearchParams).length ?
              location.pathname + '?' + newSearchParams : location.pathname);
        });
      } else {
        input.addEventListener('input', function(event) {
          const newSearchParams = new URL(location).searchParams;
          if (event.target.value) {
            newSearchParams.set(input.id, event.target.value);
          } else {
            newSearchParams.delete(input.id);
          }
          history.replaceState({}, '', Array.from(newSearchParams).length ?
              location.pathname + '?' + newSearchParams : location.pathname);
        });
      }
    });
  });
</script>


<button id="watchAdvertisements">出席</button>
<button id="test">test</button>

<script>
    // JavaScriptからLaravelへのデータ渡し成功！
    document.getElementById('test').addEventListener('click', function() {
        console.log("test1");
        const data = 'Hello World！'; // 渡したいデータ

        $.ajax({
            type: "POST", 
            url: "/", //　送り先
            data: { 'data': data }, //　渡したいデータをオブジェクトで渡す
            dataType : "json", //　データ形式を指定
            scriptCharset: 'utf-8', //　文字コードを指定
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
        .then(
            function(param){　 //　paramに処理後のデータが入って戻ってくる
                console.log(param); //　帰ってきたら実行する処理
            },
            function(XMLHttpRequest, textStatus, errorThrown){ //　エラーが起きた時はこちらが実行される
                console.log(XMLHttpRequest); //　エラー内容表示
        });
    });
</script>

<script>
  var ChromeSamples = {
    log: function() {
      var line = Array.prototype.slice.call(arguments).map(function(argument) {
        return typeof argument === 'string' ? argument : JSON.stringify(argument);
      }).join(' ');

      document.querySelector('#log').textContent += line + '\n';
    },

    clearLog: function() {
      document.querySelector('#log').textContent = '';
    },

    setStatus: function(status) {
      document.querySelector('#status').textContent = status;
    },

    setContent: function(newContent) {
      var content = document.querySelector('#content');
      while(content.hasChildNodes()) {
        content.removeChild(content.lastChild);
      }
      content.appendChild(newContent);
    }
  };
</script>

<h3>リアルタイム　アウトプット</h3>
<div id="output" class="output">
  <div id="content"></div>
  <div id="status"></div>
  <pre id="log"></pre>
</div>


<script>
  if (/Chrome\/(\d+\.\d+.\d+.\d+)/.test(navigator.userAgent)){
    // Let's log a warning if the sample is not supposed to execute on this
    // version of Chrome.
    if (87 > parseInt(RegExp.$1)) {
      ChromeSamples.setStatus('Warning! Keep in mind this sample has been tested with Chrome ' + 87 + '.');
    }
  }
</script>


<script>

function attendance(data){
        console.log("test1");
        // const data = 'Hello World！'; // 渡したいデータ

        $.ajax({
            type: "POST", 
            url: "/", //　送り先
            data: { 'data': data }, //　渡したいデータをオブジェクトで渡す
            dataType : "json", //　データ形式を指定
            scriptCharset: 'utf-8', //　文字コードを指定
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
        .then(
            function(param){　 //　paramに処理後のデータが入って戻ってくる
                console.log(param); //　帰ってきたら実行する処理
            },
            function(XMLHttpRequest, textStatus, errorThrown){ //　エラーが起きた時はこちらが実行される
                console.log(XMLHttpRequest); //　エラー内容表示
        });
}

function onWatchAdvertisementsButtonClick() {
  let service_uuid = "0000b81d-0000-1000-8000-00805f9b34fb"
  log('Requesting any Bluetooth device...');
  navigator.bluetooth.requestDevice({
// filters: [...] <- Prefer filters to save energy & show relevant devices.
    // acceptAllDevices: true,
    filters: [
    { services: [service_uuid] }
    ]
  })
  .then(device => {
    log('> Requested ' + device.name);

    device.addEventListener('advertisementreceived', (event) => {
      log('Advertisement received.');
      log('  Device Name: ' + event.device.name);
      log('  Device ID: ' + event.device.id);
      log('  RSSI: ' + event.rssi);
      log('  TX Power: ' + event.txPower);
      log('  UUIDs: ' + event.uuids);
      //　追加
      log('  text data: ' + event.serviceData.get(service_uuid));
      //
      event.manufacturerData.forEach((valueDataView, key) => {
        logDataView('Manufacturer', key, valueDataView);
      });
      event.serviceData.forEach((valueDataView, key) => {
        logDataView('Service', key, valueDataView);
      });
      // 追加(別所先生のコード)
      value = event.serviceData.get(service_uuid);
      str = String.fromCharCode.apply(null, new Uint8Array(value.buffer));
      console.log(str);
      //
    });

    log('Watching advertisements from "' + device.name + '"...');
    return device.watchAdvertisements();  
  })
  .catch(error => {
    log('Argh! ' + error);
  });
}

/* Utils */

const logDataView = (labelOfDataSource, key, valueDataView) => {
  const hexString = [...new Uint8Array(valueDataView.buffer)].map(b => {
    return b.toString(16).padStart(2, '0');
  }).join(' ');
  const textDecoder = new TextDecoder('ascii');
  const asciiString = textDecoder.decode(valueDataView.buffer);
  log(`  ${labelOfDataSource} Data: ` + key +
      '\n    (Hex) ' + hexString +
      '\n    (ASCII) ' + asciiString);
};
</script>


<script>
  log = ChromeSamples.log;

  function isWebBluetoothEnabled() {
    if (navigator.bluetooth) {
      return true;
    } else {
      ChromeSamples.setStatus('Web Bluetooth API is not available.\n' +
          'Please make sure the "Experimental Web Platform features" flag is enabled.');
      return false;
    }
  }
</script>


<script>
  if (isWebBluetoothEnabled()) {
    document.querySelector('#watchAdvertisements').addEventListener('click', function() {
        onWatchAdvertisementsButtonClick();
    });
  }
</script>
</body>
</html>
