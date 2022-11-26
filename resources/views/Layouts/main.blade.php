<html>
    <head>
        <title></title>
        <!-- STYLES -->
        <link rel="stylesheet" href="{{ asset('css/w2ui.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
        <link type="text/css" media="screen" rel="stylesheet" href="{{ asset('css/iziToast.css') }}" />

        <!-- SCRIPTS -->
        <script src="{{ asset('js/jquery-3.6.1.js') }}"></script>
        <script src="{{ asset('js/w2ui.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/iziToast.js') }}"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bulma.min.css')}}"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bm/dt-1.13.1/datatables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bulma.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.0/axios.min.js" integrity="sha512-OdkysyYNjK4CZHgB+dkw9xQp66hZ9TLqmS2vXaBrftfyJeduVhyy1cOfoxiKdi4/bfgpco6REu6Rb+V2oVIRWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body>
        <div id="navbar"></div>
        @yield('content')
    </body>
    <script>
    $("#navbar").w2toolbar({
        name: 'toolbar',
        items: [
            { type: 'button', id: 'dashboard', text: 'Dashboard', icon: "fa fa-gauge"},
            { type: 'break'},
            { type: 'menu', id: 'home', text: 'Início', icon: "fa fa-house", items: [
                { text: 'Produtos', id: 'products', icon: 'fa fa-box'},
            ]},
            { type: 'break'},
            { type: 'menu', id: 'settings', text: 'Configurações', icon: "fa fa-gear", items: [
                { text: 'Permissões', id: 'permissions', icon: 'fa fa-camera'},
            ]},
        ],
        onClick(event){
            let action = event.target;
            action = action.split(':');
            switch(action[0]){
                case 'dashboard':
                    window.location.href = "{{ route('dashboard') }}";
                    break;
                case 'home':
                    home(action[1]);
                    break;
                case 'settings':
                    settings(action[1]);
                    break;
                default:
                    break;
            }
        }
    });

    function home(action){
        switch(action){
            case 'products':
                window.location.href = "{{ route('products') }}";
                break;
        }
    }

    function settings(action){
        switch(action){
            case 'permissions':
                window.location.href = "{{ route('permissions') }}";
                break;
        }
    }
    </script>
    @yield('scripts')
</html>
