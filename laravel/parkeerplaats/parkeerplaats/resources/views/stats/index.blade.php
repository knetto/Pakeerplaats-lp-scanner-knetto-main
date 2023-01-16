@extends('layouts.app')
@section('content')
    <h3 class="title">parkeerplaats Statistieken</h3>
    @if (!$licenseplates)
        <p>Niets te zien hier, skill issue...</p>
    @else



        <div class="text mt-5 mb-5 text-white">
            <?php echo "Er zijn<strong> " .$parkingspots[0]->full_spots. "</strong> van de <strong> 200 </strong>plekken bezet<br>";?>
            <?php   
            //array voor beide waarden tabel
            $table_year_array = [];
            for($i=0;$i<= count($licenseplateDateTimes)-1;$i++){
                $dateTimeInYear = $licenseplateDateTimes[$i]->dateTime_in;  
                $dateTime_In = new DateTime($licenseplateDateTimes[$i]->dateTime_in);
                $dateTimeInYear = $dateTime_In->format('Y');
                $line = array("year"=> $dateTimeInYear, "plate"=> $licenseplates[$licenseplateDateTimes[$i]["plate_id"]-1]["plate"]);
                array_push($table_year_array, $line);
            }




            //Meest voorkomende auto
            $meestVoorkomendeAuto = [];
            foreach($licenseplateDateTimes as $licenseplateDateTime){

                $auto = $licenseplates[$licenseplateDateTime->plate_id-1]["plate"];  
                array_push($meestVoorkomendeAuto, $auto);
            }
            $count=array_count_values($meestVoorkomendeAuto);
            arsort($count);
            $keys=array_keys($count);
            echo "Deze auto heeft het meest geparkeerd<strong> ".$keys[0].".</strong><br>";

            //wat is het drukste jaar
            $allDateTimeIn_year = [];
            for($i=0;$i<= count($licenseplateDateTimes)-1;$i++){
                $dateTimeInYear = $licenseplateDateTimes[$i]->dateTime_in;  
                $dateTime_In = new DateTime($licenseplateDateTimes[$i]->dateTime_in);
                $dateTime_InYear = $dateTime_In->format('Y');
                array_push($allDateTimeIn_year, $dateTime_InYear);
            }
            $count=array_count_values($allDateTimeIn_year);

            $count2=array_count_values($allDateTimeIn_year);

            arsort($count);
            $keys=array_keys($count);
            echo "Het drukste jaar is <strong>".$keys[0].".</strong><br>";

            $years = array_unique($allDateTimeIn_year);
            $years2 = $allDateTimeIn_year;
            $yearAutos = $count;
            $yearAutos2 = $count2;

            $yearsAndAutos = array("years" => array($years2),"yearsAuto" => array($count2));      





            //wat is de drukste maand
            $allDateTimeIn_month = [];
            foreach($licenseplateDateTimes as $licenseplateDateTime){
                $dateTimeInMonth = $licenseplateDateTime->dateTime_in;  
                $dateTime_In = new DateTime($licenseplateDateTime->dateTime_in);
                $dateTime_InMonth = $dateTime_In->format('m');
                array_push($allDateTimeIn_month, $dateTime_InMonth);
            }
            $count=array_count_values($allDateTimeIn_month);
            $count2=array_count_values($allDateTimeIn_month);

            arsort($count);
            $keys=array_keys($count);

            $monthNum  = $keys[0];
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // March

            echo "De drukste maand is <strong>".$monthName.".</strong><br>";

            $months = array_unique($allDateTimeIn_month);
            $monthAutos = $count;

            $monthAutos2 = $count2;

            //hoeveel auto's er in de drukste maand gebruik hebben gemaakt van de parkeerplaats
            $allDateTimeIn_month = [];
            foreach($licenseplateDateTimes as $licenseplateDateTime){
                $dateTimeInMonth = $licenseplateDateTime->dateTime_in;  
                $dateTime_In = new DateTime($licenseplateDateTime->dateTime_in);
                $dateTime_InMonth = $dateTime_In->format('m');
                array_push($allDateTimeIn_month, $dateTime_InMonth);
            }
            $count=array_count_values($allDateTimeIn_month);
            arsort($count);
            $keys=array_keys($count);

            echo "er hebben in <strong>".$monthName."</strong> totaal <strong>".$count[$keys[0]]."</strong> auto's geparkeerd. <br>";


            $years = array_values($years);
            $yearAutos = array_values($yearAutos);
            $months = array_values($months);
            $monthAutos = array_values($monthAutos);
            // sort($years);
            // sort($yearAutos2);
            // sort($months);
            // sort($monthAutos);

            // echo '$years = ';
            // var_dump($years);
            // echo '<br>';
            // echo '$yearAutos = ';
            // var_dump($yearAutos);
            // echo '<br>';
            // echo '$months = ';
            // var_dump($months);
            // echo '<br>';
            // echo '$monthAutos = ';
            // var_dump($monthAutos);
            ?>
            
        </div>



        

        <div class="lpTable">  
            <table id="myTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Jaar <i class="fa-solid fa-sort"></i></th>
                        <th>Aantal auto's <i class="fa-solid fa-sort"></i></th>
                        <th>Gemiddelde per dag <i class="fa-solid fa-sort"></i></th>
                    </tr>
                </thead>   
                <tbody>
                    <?php
                    for($i=0;$i<= count($years)-1;$i++){
                        $gemiddelde = $yearAutos2[$years[$i]] / 365;
                        $foo = $gemiddelde;
                        $foo = number_format((float)$foo, 3, '.', '');
                        ?>
                        <tr>
                            <td>{{$years[$i]}} </td>
                            <td>{{$yearAutos2[$years[$i]]}}</td>
                            <td>{{$foo}}</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
         </table>
        </div>


      
        <div class="lpTable mt-5">  
            <table id="myTable2" class="table table-striped">
                <thead>
                    <tr>
                        <th>Maand <i class="fa-solid fa-sort"></i></th>
                        <th>Aantal auto's <i class="fa-solid fa-sort"></i></th>
                        <th>Gemiddelde per dag <i class="fa-solid fa-sort"></i></th>
                    </tr>
                </thead>   
                <tbody>
                    <?php
                    for($i=0;$i<= count($months)-1;$i++){
                        $gemiddelde = $monthAutos2[$months[$i]] / 30.5;
                        $foo = $gemiddelde;
                        $foo = number_format((float)$foo, 3, '.', '');
                        $month_name = date("F", mktime(0, 0, 0, $months[$i], 10));
                        ?>
                        <tr> 
                            <td>{{$month_name}} </td>
                            <td>{{$monthAutos2[$months[$i]]}}</td>
                            <td>{{$foo}}</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
         </table>
      </div>

      
      <?php include 'C:\Users\corne\OneDrive\Documenten\school\klas3\parkeerplaats\laravel\parkeerplaats\parkeerplaats\resources\views\stats\graphs.php';?>

      <div class="mt-5 d-flex justify-content-center" id="chartContainer" style="height: 370px; width: 50%;"></div>
      
      <div class="mt-5 d-flex justify-content-center" id="chartContainer1" style="height: 370px; width: 50%;"></div>
      
      <script src="https://canvasjs.com/assets/script/canvasjs.min.js">


    @endif

@endsection
