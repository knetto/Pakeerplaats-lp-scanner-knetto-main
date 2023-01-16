@extends('layouts.app')
@section('content')

    <h3 class="title">Geparkeerde auto's</h3>
    @if (!$licenseplates)
        <p>Niets te zien hier, skill issue...</p>
    @else
    <div class="lpTable">  
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Nummerbord <i class="fa-solid fa-sort"></i></th>
                    <th>Tijd binnenkomst <i class="fa-solid fa-sort"></i></th>
                    <th>Geparkeerde tijd <i class="fa-solid fa-sort"></i></th>
                </tr>
            </thead>


            <?PHP
          
            ?>

        <tbody>    
         @foreach($licenseplateDateTimes as $licenseplateDateTime)
            @if($licenseplateDateTime->dateTime_out == NULL)
    
             <?PHP
            date_default_timezone_set("Europe/Amsterdam"); 
            $datetime_1 = date("Y-m-d H:i:s"); 
            $datetime_2 = $licenseplateDateTime->dateTime_in; 
            $date1=date_create("$datetime_1");
            $date2=date_create("$datetime_2");
            $diff=date_diff($date1,$date2);
            ?>    

            <tr>
             <td>{{$licenseplates[$licenseplateDateTime->plate_id-1]["plate"]}}</td>
             <td>{{$licenseplateDateTime->dateTime_in}}</td>
             <td>
                <?php 
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days*24);
                 if ($diff->h < "1" && $diff->d < "1") {
                    echo $diff->i, " minuten";
                 }
                 else {
                    echo $hours, " uur";
                 }
                 ?></td>
            </tr>
            @endif
         @endforeach
        </tbody>
     </table>
  </div>
    @endif



@endsection



