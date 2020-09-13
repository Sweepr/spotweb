document.addEventListener('DOMContentLoaded', init, false);

function init(){
  adsBlockes(function(blocked){
    if(blocked){
      window.open("adblocker_detected.html","_self")
    } else {
      document.getElementById('result').innerHTML = '';
    }
  })
}

function adsBlockes(callback){
  var testURL = 'www.googletagmanager.com'
  var myInit = {
    method: 'HEAD',
    mode: 'no-cors'
  };

  var myRequest = new Request(testURL, myInit);

  fetch(myRequest).then(function(response) {
    return response;
  }).then(function(response) {
    console.log(response);
    callback(false)
  }).catch(function(e){
    console.log(e)
    callback(true)
  });
}