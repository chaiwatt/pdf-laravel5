<style>
    .header {
        width: 100%;
        text-align: center;
        margin-bottom: 20px;
    }

    .header-title {
        font-size: 18px;
        font-weight: bold;
        line-height: 1.5;
    }

    .sub-header {
        font-size: 14px;
        margin-top: 5px;
        line-height: 1.5;
    }

    .lab-info {
        width: 100%;
        margin-top: 20px;
        margin-bottom: 20px;
        
    }

    .lab-info div {
        display: inline-block;
        width: 30%;
        vertical-align: top;
        text-align: center;
        font-size: 14px;
        line-height: 1.4;
        background-color: brown
    }

    .lab-info div label {
        display: inline;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .checkbox-container {
        text-align: center;
        margin-top: 15px;
    }

    .checkbox-container div {
        display: inline-block;
        width: 30%;
        text-align: center;
        font-size: 14px;
        line-height: 1.4;
    }

    .checkbox-container input[type="checkbox"] {
        transform: scale(1.2);
        margin-right: 5px;
    }

    .logo {
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        margin: 10px;
    }

    .date-info {
        font-size: 14px;
        margin-top: 20px;
        text-align: center;
    }

    .date-info div {
        display: inline-block;
        width: 30%;
        text-align: center;
        font-size: 14px;
        line-height: 1.4;
    }
</style>

<div class="content">
    <!-- Header Section -->
    <div class="header">
        <div class="header-title">
            รายละเอียดสถานะและขอบข่ายในใบรับรองห้องปฏิบัติการ <br>
            (Scope of Accreditation for Calibration)
        </div>
        <div class="sub-header">
            ใบรับรองเลขที่ 22-LB0083 <br>
            (Certification no. 22-LB0083)
        </div>
    </div>

    <!-- Laboratory Info Section -->
    <div class="lab-info">
        <div>
            <label>ชื่อห้องปฏิบัติการ</label>
            บริษัท ครีเอทีฟ โพลีเมอร์ส จำกัด <br>
            (Creative Polymers Ltd.)
        </div>
        <div>
            <label>หมายเลขการรับรอง</label>
            สอบเทียบ 0352 <br>
            (Calibration 0352)
        </div>
        <div>
            <label>ฉบับที่</label>
            02 <br>
            (Issue No. 02)
        </div>
    </div>

    <!-- Status Section -->
    <div class="checkbox-container">
        <div>
            <input type="checkbox" checked> ถาวร <br>
            (Permanent)
        </div>
        <div>
            <input type="checkbox"> นอกสถานที่ <br>
            (Site)
        </div>
        <div>
            <input type="checkbox"> ชั่วคราว <br>
            (Temporary)
        </div>
    </div>

    <!-- Date Info Section -->
    <div class="date-info">
        <div>
            ออกให้ตั้งแต่วันที่ 30 สิงหาคม พ.ศ. 2566 <br>
            (Valid from) (30th August B.E. 2566 (2023))
        </div>
        <div>
            ถึงวันที่ 30 พฤษภาคม พ.ศ. 2567 <br>
            (Until) (30th May B.E. 2567 (2024))
        </div>
    </div>

    <!-- Logo -->
    <img class="logo" src="{{ public_path('path/to/logo.png') }}" alt="logo">
</div>
