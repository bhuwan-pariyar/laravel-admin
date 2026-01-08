@push('custom-styles')
    <style>
        .crumbs {
            text-align: left;
        }

        .crumbs ul {
            list-style: none;
            display: inline-table;
        }

        .crumbs ul li {
            display: inline;
        }

        .crumbs ul li a {
            display: block;
            float: left;
            height: 30px;
            background: #F1F2F3;
            text-align: center;
            padding: 5px 15px 0px 30px;
            position: relative;
            margin: 0 10px 0 0;
            font-size: 10px;
            text-decoration: none;
            text-transform: uppercase;
            color: #000000;
            line-height: 20px;
        }

        .crumbs ul li a:after {
            content: "";
            border-top: 15px solid transparent;
            border-bottom: 15px solid transparent;
            border-left: 15px solid #F1F2F3;
            position: absolute;
            right: -15px;
            top: 0;
            z-index: 1;
        }

        .crumbs ul li a:before {
            content: "";
            border-top: 15px solid transparent;
            border-bottom: 15px solid transparent;
            border-left: 15px solid #fff;
            position: absolute;
            left: 0;
            top: 0;
        }

        .crumbs ul li:first-child a {
            padding-left: 15px;
        }

        .crumbs ul li:first-child a:before {
            display: none;
        }

        .crumbs ul li:last-child a {
            padding-right: 30px;
            background: #1e293b;
            color: #F1F5FB
        }

        .crumbs ul li:last-child a:after {
            border-left-color: #1e293b;
        }

        .crumbs ul li a:hover {
            background: #1e293b;
            color: #fff;
        }

        .crumbs ul li a:hover:after {
            border-left-color: #1e293b;
            color: #fff;
        }
    </style>
@endpush

<nav class="flex px-5 py-2 bg-slate-50" aria-label="Breadcrumb">
    <div class="crumbs text-left">
        <ul class="list-none inline-table">
            {{ $slot }}
        </ul>
    </div>
</nav>
