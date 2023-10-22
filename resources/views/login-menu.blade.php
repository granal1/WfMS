<nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm" 
    style=" font-size: 1.25em;
    --bs-bg-opacity: .1;
    backdrop-filter: blur(40px);
    -webkit-backdrop-filter: blur(40px);">

    <div class="container collapse navbar-collapse" id="navbarSupportedContent">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @guest
        <ul class="nav" role="tablist">
            <li class="nav-item text-white">
                <a class="nav-link active hidden" style="padding:0; margin-right: 16px;" data-bs-toggle="pill" href="#home">
                    <img class="navbar-brand" style="padding:0; margin:0;" alt="Navbar picture" src="{{asset('assets/icons/edp.svg')}}" height="40px">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="pill" href="#description">Описание</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="pill" href="#demonstration">Демонстрация</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/support/edp-guide.pdf" target="_blank">Документация</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="pill" href="#development">Развитие</a>
            </li>
        </ul>

        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#login">
                    Войти
                </button>
            </li>
        </ul>
        @endguest
    </div>
</nav>
