<div class="px-3 py-2 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="{{ $nav['title']->link }}" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                {{ $nav['title']->label }}
            </a>

            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">

                {{-- @foreach($nav['links'] as $link)
                <li>
                    <a href="{{ $link->link }}" class="nav-link {{ $link->current ? 'text-secondary' : 'text-white' }} ">
                        <svg class="bi d-block mx-auto mb-1" width="24" height="24">
                            <use xlink:href="#home"></use>
                        </svg>
                        {{ $link->label }}
                    </a>
                </li>
                @endforeach --}}
            </ul>
        </div>
    </div>
</div>