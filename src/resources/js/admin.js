/** for bootstrp5 dynamic toaster */
var toast_to = '';
function showToaster(obj) {
  var title = obj.title;
  var message = obj.message;
  var alert = typeof obj.alert == 'undefined' ? true : obj.alert;
  toast_to = typeof obj.url != 'undefined' ? obj.url : '';
  if (toast_to) {
    $(".toast-footer").removeClass('d-none');
  } else {
    $(".toast-footer").addClass('d-none');
  }

  $("#toast-container").prepend($("#toast-placement").html());
  $toaster = $(".toast-placement").eq(0);
  $toaster.find('.me-auto').html(title);
  $toaster.find('.toast-body').html(message);

  if (alert) {
    $toaster.find('.toast-header').addClass('text-dark bg-warning');
  } else {
    $toaster.find('.toast-header').addClass('text-white bg-success');
  }
  
  $toaster.toast({delay: 5000});
  $toaster.toast('show'); // OK
  $toaster.on('hidden.bs.toast', function($ev){
    $ev.currentTarget.remove();
  })
}


// 새 창
function window_open (url, winname, params) {
  var defaultOpt = {width: 700, height: 500, scrollbars: 'auto'};

  params = params || [];
  var objs = [defaultOpt, params];
  var newOpts =  objs.reduce(function (r, o) {
    Object.keys(o).forEach(function (k) {
      r[k] = o[k];
    });
    return r;
  }, {});

  newOpts.left = (document.body.offsetWidth / 2) - (200 / 2);
  //&nbsp;만들 팝업창 좌우 크기의 1/2 만큼 보정값으로 빼주었음

  newOpts.top= (window.screen.height / 2) - (300 / 2);
  //&nbsp;만들 팝업창 상하 크기의 1/2 만큼 보정값으로 빼주었음

  var opt = 'scrollbars = ' + newOpts.scrollbars + ', width=' + newOpts.width + ', height=' + newOpts.height + ', left=' + newOpts.left + ', top=' + newOpts.top;
  window.open(url, winname, opt);
}

function win_user(url) {
  window_open(url, '', {width: 900, height: 600});
}