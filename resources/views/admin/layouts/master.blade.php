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
                @if(session('msg'))
                    <div class="alert alert-success">{{ session('msg') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('legacy/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('legacy/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('legacy/admin/js/main.js') }}"></script>
    {{-- small UX helpers: toast container and ajax feedback --}}
    <div id="admin-toast-container" style="position:fixed;right:20px;top:20px;z-index:99999"></div>
    <script>
        (function(){
            // auto-hide any server flash alerts and convert them to toasts
            document.addEventListener('DOMContentLoaded', function(){
                // move existing alerts into toast container
                document.querySelectorAll('.alert').forEach(function(el){
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
