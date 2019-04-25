@extends('layouts.default')

@section('content')

<div class="filter">

<form action="/filter" method="get">

    <!-- Director -->

    <div class="filter_unit">
<span>Director:</span>
<select class='director' name="director" id="">
        <option value=""></option>
@forelse($directors as $director)
     <option value="{{$director->id}}">{{$director->name}}</option>
@empty
    <p>no directors, sorry =(</p>
@endforelse
</select>
    </div>

    <!-- Year -->

    <div class="filter_unit">
        <span>Year:</span>
<select class='year' name="year" id="">
    <option value=""></option>
                @forelse($films as $film)
            <option value="{{$film->year}}">{{$film->year}}</option>
        @empty
            <p>no films, sorry =(</p>
        @endforelse
</select>
    </div>

    <!-- Rate -->

    <div class="filter_unit">
        <span>Rate:</span>
<select class='rate' name="rate" id="">

        <option value=""></option>
        @forelse($rate as $r)
            <option value="{{$r->rate}}">{{$r->rate}}</option>
        @empty
            <p>no films, sorry =(</p>
        @endforelse
</select>
    </div>

    <!-- Price -->

    @if($errors->has('min_price')||$errors->has('max_price'))
        <p class="error">{{$errors->first('min_price')}}</p>
        <p class="error">{{$errors->first('max_price')}}</p>
    @endif

    <div class="filter_unit">
        Price from:<input class="price" type="text" name="min_price" value="{{session('min_price')}}">
        To:<input class="price" type="text" name="max_price" value="{{session('max_price')}}">
    </div>

    <!-- Genres -->

    <div class="filter_unit">
@forelse($genres as $genre)
        @if(in_array($genre->id,session('genres')))
                <input type="checkbox" name="genre[]" value="{{$genre->id}}" checked>{{$genre->name}}<br>
            @else
                <input type="checkbox" name="genre[]" value="{{$genre->id}}">{{$genre->name}}<br>
        @endif
    @empty
        <p>no films, sorry =(</p>
    @endforelse

    <input type="submit">
    </div>

</form>
</div>


<div class="films">
    <table>
        <tr>
            <th>Film name</th>
            <th>Director</th>
            <th>Year</th>
            <th>Rate</th>
            <th>Price</th>
        </tr>
@forelse($films as $film)
    <tr>
        <td>{{$film->name}}</td>
        <td>{{$film->getDirector()->name}}</td>
        <td>{{$film->year}}</td>
        <td>{{$film->rate}}</td>
        <td>{{$film->price}}</td>
    </tr>
    @empty
    <p>no films, sorry =(</p>
@endforelse
    </table>
</div>
    @endsection
