@extends('layouts.app')
@section('content')
    <h3 class="title">Parkeerplaats geschiedenis</h3>
    @if (!$licenseplates)
        <p>Niets te zien hier, skill issue...</p>
    @else



    
    <div class="lpTable">  
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Nummerbord <i class="fa-solid fa-sort"></i></th>
                    <th>Tijd binnenkomst <i class="fa-solid fa-sort"></i></th>
                    <th>Tijd Vertrek <i class="fa-solid fa-sort"></i></th>
                    <th>Geparkeerde tijd <i class="fa-solid fa-sort"></i></th>
                </tr>
            </thead>
        <tbody>    
         @foreach($licenseplateDateTimes as $licenseplateDateTime)
            @if($licenseplateDateTime->dateTime_out !== NULL)

            
             <?PHP
             
             $datetime_1 = $licenseplateDateTime->dateTime_out; 
             $datetime_2 = $licenseplateDateTime->dateTime_in; 

             $start_datetime = new DateTime($datetime_1); 
             $diff = $start_datetime->diff(new DateTime($datetime_2)); 
            ?>    



            <tr>
             <td>{{$licenseplates[$licenseplateDateTime->plate_id-1]["plate"]}}</td>
             <td>{{$licenseplateDateTime->dateTime_in}}</td>
             <td>{{$licenseplateDateTime->dateTime_out}}</td>
             <td>
            <?php 
                 $hours = $diff->h;
                 $hours = $hours + ($diff->days*24);
                 
                 if ($diff->h < "1" && $diff->days < "1") {
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
