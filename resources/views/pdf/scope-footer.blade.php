<div width="100%" style="display:inline;line-height:16px">

  <div style="display:inline-block;line-height:16px;float:left;width:70%">
    <span style="font-size:22px">กระทรวงอุตสาหกรรม สํานักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</span><br> 
    <span style="font-size: 16px">(Ministry of Industry, Thai Industrial Standards Institute)</span>  
  </div>

  <div style="display: inline-block; width: 15%;float:right;width:25%">
    
    {{-- @if($qrImage)
      <div style="display: inline-block; width: 25%; float:left;">
        <img src="data:image/png;base64,{{ $qrImage }}" style="width: 50px" alt="QR Code" />
      </div>
    @endif --}}

    @if($sign1Image)
      <div style="display: inline-block; width: 31%;float:left;">
        <img src="{{ $sign1Image }}" style="width: 50px"/>
      </div>
    @endif

    @if($sign1Image)
      <div style="display: inline-block; width: 31%;margin-left:6px;float:left;">
        <img src="{{ $sign2Image }}" style="width: 50px"/>
      </div>
    @endif
    
    @if($sign3Image)
      <div style="display: inline-block;  width:31% ;float:right;">
        <img src="{{ $sign3Image }}" style="width: 50px"/>
      </div>
    @endif
    
  </div>

  <div width="100%" style="display:inline;text-align:center">
    <span>หน้าที่ {PAGENO}/{nb}</span>
  </div>
</div>
