<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Car Rental</title>
    <link rel="stylesheet" href="{{ asset('legacy/admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy/admin/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy/admin/css/style.css') }}">
    @stack('styles')
    <style>body{background:#f5f5f5}</style>
</head>
<body>
    @include('admin.includes.header')
    <div class="ts-main-content">
        @include('admin.includes.leftbar')
        <div class="content-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    @include('partials.modals.admin_logout_confirm')

    {{-- Success Modal for Admin --}}
    @if(session('success_modal'))
    <div id="adminSuccessModal" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:99999;display:flex;align-items:center;justify-content:center;">
      <div style="background:white;padding:40px;border-radius:8px;box-shadow:0 4px 20px rgba(0,0,0,0.3);text-align:center;max-width:400px;animation:slideIn 0.3s ease-out;">
        <div style="margin-bottom:20px;">
          <i class="fa fa-check-circle" style="font-size:60px;color:#4caf50;"></i>
        </div>
        <h3 style="color:#2c3e50;margin-bottom:15px;font-weight:600;">Success!</h3>
        <p style="color:#7f8c8d;font-size:16px;margin-bottom:30px;">{{ session('success_modal') }}</p>
        <button onclick="document.getElementById('adminSuccessModal').style.display='none'" class="btn btn-primary" style="padding:10px 40px;font-size:16px;background:#4caf50;border:none;border-radius:4px;cursor:pointer;">
          OK
        </button>
      </div>
    </div>
    <style>
      @keyframes slideIn {
        from {
          transform: translateY(-50px);
          opacity: 0;
        }
        to {
          transform: translateY(0);
          opacity: 1;
        }
      }
    </style>
    <script>
      setTimeout(function(){ 
        var modal = document.getElementById('adminSuccessModal');
        if(modal) {
          modal.style.opacity = '0';
          modal.style.transition = 'opacity 0.3s';
          setTimeout(function(){ modal.style.display = 'none'; }, 300);
        }
      }, 6000);
    </script>
    @endif

    <script src="{{ asset('legacy/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('legacy/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('legacy/admin/js/main.js') }}"></script>
    {{-- small UX helpers: toast container and ajax feedback --}}
    <div id="admin-toast-container" style="position:fixed;right:20px;top:20px;z-index:99999"></div>
    <script>
        (function(){
            // auto-hide any server flash alerts and convert them to toasts
            document.addEventListener('DOMContentLoaded', function(){
                // move existing alerts into toast container, but skip validation errors
                document.querySelectorAll('.alert').forEach(function(el){
                    // Skip alerts that are inside panel-body (form validation errors)
                    if (el.closest('.panel-body')) return;
                    
                    var clone = el.cloneNode(true);
                    clone.classList.add('alert-dismissible');
                    var btn = document.createElement('button');
                    btn.type='button'; btn.className='close'; btn.innerHTML='&times;';
                    btn.onclick=function(){ clone.remove(); };
                    clone.appendChild(btn);
                    var wrapper = document.createElement('div');
                    wrapper.appendChild(clone);
                    document.getElementById('admin-toast-container').appendChild(wrapper);
                    setTimeout(function(){ try{ wrapper.remove(); }catch(e){} }, 6000);
                });

                // global fetch wrapper for JSON responses
                window.adminFetch = function(url, options){
                    options = options || {};
                    options.headers = Object.assign({
                        'X-Requested-With':'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }, options.headers || {});
                    return fetch(url, options).then(function(res){
                        if (!res.ok) throw res;
                        return res.json().catch(function(){ return res.text(); });
                    }).then(function(data){
                        if (typeof data === 'object' && data.message) {
                            showAdminToast(data.message, data.status || 'success');
                        }
                        return data;
                    }).catch(function(err){
                        showAdminToast('Request failed', 'danger');
                        throw err;
                    });
                };

                window.showAdminToast = function(message, level){
                    level = level || 'success';
                    var div = document.createElement('div');
                    div.className = 'alert alert-' + level + ' alert-dismissible';
                    div.style.marginBottom = '8px';
                    div.innerHTML = message;
                    var btn = document.createElement('button'); btn.type='button'; btn.className='close'; btn.innerHTML='&times;';
                    btn.onclick = function(){ div.remove(); };
                    div.appendChild(btn);
                    document.getElementById('admin-toast-container').appendChild(div);
                    setTimeout(function(){ try{ div.remove(); }catch(e){} }, 5000);
                };
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
