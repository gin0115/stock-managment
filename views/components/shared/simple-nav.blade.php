<div class="px-3 py-2 {!! $wrapper_class | esc_attr !!}">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            {!! $this->component($title, false) !!}

            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">

                @foreach($links as $link)
                <li>
                    {!! $this->component($link) !!}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>