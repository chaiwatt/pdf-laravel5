{{-- 
<div class="content mt-10">
    <div class="content mt-10">
        <table width="100%" style="border: 0.5px solid #000; border-collapse: collapse" cellspacing="0" cellpadding="5">
            <tr>
                <td class="text-center" style="border: 0.5px solid #000;width:15%">สาขาการสอบเทียบ<br><span style="font-size: 14px;">(Field of Calibration)</span></td>
                <td class="text-center" style="border: 0.5px solid #000;width:30%">รายการสอบเทียบ<br><span style="font-size: 14px;">(Parameter)</span></td>
                <td class="text-center" style="border: 0.5px solid #000;width:30%">ขีดความสามารถของ<br>การสอบเทียบและการวัด*<br><span style="font-size: 14px;">(Calibration and Measurement Capability*)</span></td>
                <td class="text-center" style="border: 0.5px solid #000;width:25%">วิธีการสอบเทียบ<br><span style="font-size: 14px;">(Calibration Method)</span></td>
            </tr>
            @for ($i = 1; $i <= 4; $i++)
            <tr >
                <td style="border: 0.5px solid #000;padding-left:10px ;" >1. อุณหภูมิ<br>(Temperature)</td>
                <td style="border: 0.5px solid #000;padding-left:10px">
                    Temperature indicator with sensor<br>
                    Thermocouple type K, T, E, J, N<br>
                    0 °C<br>
                    50 °C to 100 °C<br>
                    > 100 °C to 150 °C<br>
                    > 150 °C to 200 °C<br>
                    > 200 °C to 250 °C<br>
                    > 250 °C to 300 °C<br><br>
                    Resistance thermometer<br>
                    0 °C<br>
                    50 °C to 150 °C<br>
                    > 150 °C to 300 °C
                  
                </td>
                <td class="text-center" style="border: 0.5px solid #000;padding-left:10px">
                    0.10 °C<br>
                    0.40 °C<br>
                    0.60 °C<br>
                    0.75 °C<br>
                    0.90 °C<br>
                    1.1 °C<br><br>
                    0.055 °C<br>
                    0.10 °C<br>
                    0.13 °C
                  
                </td>
                <td style="border: 0.5px solid #000;padding-left:10px">
                    Comparison technique with PRT
                 
                </td>
            </tr>
            @endfor
        
           
            
            
          
        </table>
    </div>

</div>
 --}}

 <?php
$firstNames = ['John', 'Jane', 'Michael', 'Emily', 'David', 'Sarah', 'Chris', 'Jessica', 'Daniel', 'Laura'];
$lastNames = ['Smith', 'Johnson', 'Brown', 'Williams', 'Jones', 'Garcia', 'Miller', 'Davis', 'Martinez', 'Hernandez'];

// Lorem Ipsum text to be used for generating random description
$loremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

// Function to generate a random description between 20 and 200 words
function getRandomDescription($loremIpsum) {
    $words = explode(' ', $loremIpsum);
    $numWords = rand(5, 20); // Random number of words between 20 and 200
    $randomWords = array_slice($words, 0, $numWords);
    return implode(' ', $randomWords);
}
?>
@for ($i = 0; $i < 100; $i++)
<span>
    <div style="position: relative;width:100%;margin-top:10px">
        <div style="display:inline-block;width:16%;float: left;margin-left:5px">{{ $firstNames[array_rand($firstNames)] }} </div>
        <div style="display:inline-block;width:24%;float: left;margin-left:5px">{{ $lastNames[array_rand($lastNames)] }} </div>
        <div style="display:inline-block;width:30%;float: left;margin-left:5px">{{ getRandomDescription($loremIpsum) }} </div>
        <div style="display:inline-block;width:23%;float: right;margin-left:5px">{{ rand(50, 100) }} </div>
    </div>
</span>

@endfor

    {{-- <div class="content">
    <table width="100%" style="border: 0.5px solid #000; border-collapse: collapse" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <td class="text-center" style="border: 0.5px solid #000;width:15%;font-size: 22px;">สาขาการสอบเทียบ<br><span style="font-size: 14px;">(Field of Calibration)</span></td>
                <td class="text-center" style="border: 0.5px solid #000;width:30%;font-size: 22px;">รายการสอบเทียบ<br><span style="font-size: 14px;">(Parameter)</span></td>
                <td class="text-center" style="border: 0.5px solid #000;width:30%;font-size: 22px;">ขีดความสามารถของ<br>การสอบเทียบและการวัด*<br><span style="font-size: 14px;">(Calibration and Measurement Capability*)</span></td>
                <td class="text-center" style="border: 0.5px solid #000;width:25%;font-size: 22px;">วิธีการสอบเทียบ<br><span style="font-size: 14px;">(Calibration Method)</span></td>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 100; $i++)
                <tr>
                    <td style="border: 0.5px solid #000;padding-left:10px ;width:20%;font-size: 22px;" >{{ $firstNames[array_rand($firstNames)] }}</td> <!-- สุ่มชื่อ -->
                    <td style="border: 0.5px solid #000;padding-left:10px ;width:25%;font-size: 22px;" >{{ $lastNames[array_rand($lastNames)] }}</td> <!-- สุ่มนามสกุล -->
                    <td style="border: 0.5px solid #000;padding-left:10px ;width:25%;font-size: 22px;" >{{ getRandomDescription($loremIpsum) }}</td> <!-- สุ่มคำอธิบาย 20 - 200 คำ -->
                    <td style="border: 0.5px solid #000;padding-left:10px ;width:30%;font-size: 22px;" >{{ rand(50, 100) }}</td> <!-- สุ่มคะแนนระหว่าง 50 ถึง 100 -->
                </tr>
            @endfor
        </tbody>
    </table>

    </div> --}}
