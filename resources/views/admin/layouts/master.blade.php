<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Car Rental</title>
    <!-- Google Fonts: Lato (HTTPS) -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900,100italic,300italic,400italic,700italic,900italic" rel="stylesheet" type="text/css">
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
    @if(session('success'))
    <div id="adminSuccessModal" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:99999;display:flex;align-items:center;justify-content:center;">
      <div style="background:white;padding:40px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.3);text-align:center;max-width:450px;animation:slideIn 0.3s ease-out;">
        <div style="margin-bottom:20px;">
          <i class="fa fa-smile-o" style="font-size:70px;color:#4CAF50;"></i>
        </div>
        <h3 style="color:#2c3e50;margin-bottom:15px;font-weight:600;font-size:24px;">Success!</h3>
        <p style="color:#7f8c8d;font-size:16px;margin-bottom:30px;line-height:1.5;">{{ session('success') }}</p>
        <button onclick="document.getElementById('adminSuccessModal').style.display='none'" class="btn btn-success" style="padding:12px 50px;font-size:16px;background:#4CAF50;border:none;border-radius:6px;cursor:pointer;color:white;font-weight:600;">
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
    @endif

    {{-- Error Modal for Admin --}}
    @if(session('error'))
    <div id="adminErrorModal" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:99999;display:flex;align-items:center;justify-content:center;">
      <div style="background:white;padding:40px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.3);text-align:center;max-width:450px;animation:slideIn 0.3s ease-out;">
        <div style="margin-bottom:20px;">
          <i class="fa fa-frown-o" style="font-size:70px;color:#f44336;"></i>
        </div>
        <h3 style="color:#2c3e50;margin-bottom:15px;font-weight:600;font-size:24px;">Oops!</h3>
        <p style="color:#7f8c8d;font-size:16px;margin-bottom:30px;line-height:1.5;">{{ session('error') }}</p>
        <button onclick="document.getElementById('adminErrorModal').style.display='none'" class="btn btn-danger" style="padding:12px 50px;font-size:16px;background:#f44336;border:none;border-radius:6px;cursor:pointer;color:white;font-weight:600;">
          OK
        </button>
      </div>
    </div>
    @endif

    <script src="{{ asset('legacy/admin/js/jquery.min.js') }}"></script>
    <!-- DataTables JS (after jQuery) -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>
    <script src="{{ asset('legacy/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('legacy/admin/js/main.js') }}"></script>
    
    <script>
        // Auto-hide admin success and error modals after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('#adminSuccessModal').fadeOut('slow');
                $('#adminErrorModal').fadeOut('slow');
            }, 5000);
        });
    </script>
    
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
