<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 23.04.2019
 * Time: 15:45
 */

namespace App;


use App\Models\Director;
use App\Models\Film;
use App\Models\Film_genres;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainService
{
    protected $request;
    /**
     * MainService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filterHandle(){
        $data = [];
        $directors = Director::select();
        $films = Film::select();
        $genres = Genre::select();
        $rate = Film::select('rate')->groupBy('rate');
        session(['genres'=>[]]);
        $max_price = DB::table('films')->max('price');
        $min_price = DB::table('films')->min('price');
        session(['max_price'=>$max_price]);
        session(['min_price'=>$min_price]);

        if (!is_null($this->request->get('min_price')) && $this->request->get('min_price')>$min_price){
            $films = $films->
            where('price','>',$this->request->get('min_price'));
            session(['min_price'=>$this->request->get('min_price')]);
        }

        if (!is_null($this->request->get('max_price')) && $this->request->get('max_price')<$max_price){
            $films = $films->
            where('price','<',$this->request->get('max_price'));
            session(['max_price'=>$this->request->get('max_price')]);
        }

        if (!is_null($this->request->get('director'))){
            $films = $films->
            where('director_id',$this->request->get('director'));
            $directors = $directors->where('id',$this->request->get('director'));
        }

        if (!is_null($this->request->get('year'))){
            $films = $films->
            where('year',$this->request->get('year'));

            $directors = $directors->whereIn('id',Film::select('director_id')->
            where('year',$this->request->get('year'))->get());
        }

        if (!is_null($this->request->get('rate'))){
            $films = $films->where('rate','>=',$this->request->get('rate'));
            $rate = Film::select('rate')->where('rate','>=',$this->request->get('rate'))
                ->groupBy('rate');
        }

        if (!is_null($this->request->get('genre'))){
            $films = $films->whereIn('id',Film_genres::select('film_id')->whereIn('genre_id',
                $this->request->get('genre'))->get());
            $directors = $directors->whereIn('id',Film::select('director_id')->
            whereIn('id',Film_genres::select('film_id')->whereIn('genre_id',
                $this->request->get('genre'))->get())->get());

            session(['genres'=>$this->request->get('genre')]);
        }
        $data['directors']=$directors->get();
        $data['films']=$films->get();
        $data['rate'] = $rate->get();
        $data['genres']=$genres->get();

        return $data;
    }
}
