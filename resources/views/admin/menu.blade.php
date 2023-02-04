@foreach($menu['categories'] as $category)
    <div class="row">
        <div class="col px-3">
            <h3 class="mx-2">{{ $category['name'] }}</h3>
            @foreach($category['dishes'] as $dish)
                <div class="dish row" id="{{$dish['id']}}">
    {{--                <div class="col-1 text-center px-0">--}}
    {{--                    <input type="checkbox" name="selected[]" class="checkbox" value={{$dish['id']}}>--}}
    {{--                </div>--}}
                    <div class="col-8 col-md-5">
                        <table border=0>
                            <tr>
                                 <td valign='top' class='sorthandle' title="В пределах одного раздела можно менять порядок блюд мышкой">

                                 </td>
                                <td valign='top'>
                                    <div class="mx-2">
                                        <a href="{{ route('platform.dish', ['id'=>$dish['id']])  }}" title="Редактировать блюдо">{{ $dish['name'] }}</a>
                                    </div>
                                    <div class="mx-2 small text-secondary">
                                        #{{ $dish['id'] }}
                                        {{ $dish['shortname'] }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="d-none d-md-block col-2">
                        <img src='/images/{{ session('company_id') }}/{{ $dish['photo'] }}' title="{{ $dish['photo'] }}" class='img-fluid'>
                    </div>
                    <div class="d-none d-md-block col-2">
                        <span class="small text-secondary line-3 compressed-line-height" id="content_[[+id]]">{{ $dish['description'] }}</span>
                    </div>
                    <div class="col-3 col-md-2">
                        <span id="price_[[+id]]">{{ $dish['price'] }}</span> <span class='small font-weight-bold'></span> руб.<br>
                        <span class="small text-secondary line-1" id="volume_[[+id]]">{{ $dish['size'] }} </span>
                        <span class="small text-secondary line-1" id="kbju_[[+id]]">{{ $dish['kbju'] }} </span>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
@endforeach
