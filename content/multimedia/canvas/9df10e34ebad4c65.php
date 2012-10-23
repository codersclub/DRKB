<h1>Работа с изображением в памяти</h1>
<div class="date">01.01.2007</div>


<p>Вот кусок одного моего класса, в котором есть две интересные вещицы -</p>
<p>проецирование файлов в память и работа с битмэпом в памяти через указатель.</p>

<pre>
type 
   TarrRGBTriple=array[byte] of TRGBTriple; 
   ParrRGBTriple=^TarrRGBTriple; 
 
 
{организует битмэп размером SX,SY;true_color} 
procedure TMBitmap.Allocate(SX,SY:integer); 
var DC:HDC; 
begin 
  if BM&lt;&gt;0 then DeleteObject(BM);   {удаляем старый битмэп, если был} 
  BM:=0;  PB:=nil; 
  fillchar(BI,sizeof(BI),0); 
  with BI.bmiHeader do        {заполняем структуру с параметрами битмэпа} 
  begin 
    biSize:=sizeof(BI.bmiHeader); 
    biWidth:=SX;  biHeight:=SY; 
    biPlanes:=1;  biBitCount:=24; 
    biCompression:=BI_RGB; 
    biSizeImage:=0; 
    biXPelsPerMeter:=0;  biYPelsPerMeter:=0; 
 
    biClrUsed:=0;        biClrImportant:=0; 
 
    FLineSize:=(biWidth+1)*3 and (-1 shl 2); {размер строки(кратна 4 байтам)} 
 
    if (biWidth or biHeight)&lt;&gt;0 then 
     begin 
       DC:=CreateDC('DISPLAY',nil,nil,nil); 
{замечательная функция (см.HELP), возвращает HBITMAP, позволяет сразу разместить выделяемый битмэп в спроецированном файле,
что позволяет ускорять работу и экономить память при генерировании большого битмэпа} 
      BM:=CreateDIBSection(DC,BI, DIB_RGB_COLORS, pointer(PB), nil, 0); 
 
       DeleteDC(DC);  {в PB получаем указатель на битмэп-----^^} 
       if BM=0 then Error('error creating DIB'); 
     end; 
  end; 
end; 
 
{эта процедура загружает из файла true-color'ный битмэп} 
procedure TMBitmap.LoadFromFile(const FileName:string); 
var HF:integer; {file handle} 
    HM:THandle; {file-mapping handle} 
    PF:pchar;   {pointer to file view in memory} 
    i,j:integer; 
    Ofs:integer; 
begin 
{открываем файл} 
  HF:=FileOpen(FileName,fmOpenRead or fmShareDenyWrite); 
 
  if HF&lt;0 then Error('open file '''+FileName+''''); 
  try 
{создаем объект-проецируемый файл} 
    HM:=CreateFileMapping(HF,nil,PAGE_READONLY,0,0,nil); 
    if HM=0 then Error('cannot create file mapping'); 
   try 
{собственно проецируем объект в адресное } 
       PF:=MapViewOfFile(HM,FILE_MAP_READ,0,0,0); 
{получаем указатель на область памяти, в которую спроецирован файл} 
       if PF=nil then Error('cannot create map view of file'); 
      try 
{работаем с файлом как с областью памяти через указатель PF} 
 
         if PBitmapFileHeader(PF)^.bfType&lt;&gt;$4D42 then  Error('file format'); 
         Ofs:=PBitmapFileHeader(PF)^.bfOffBits; 
         with PBitmapInfo(PF+sizeof(TBitmapFileHeader))^.bmiHeader do 
         begin 
           if (biSize&lt;&gt;40) or (biPlanes&lt;&gt;1) then Error('file format'); 
           if (biCompression&lt;&gt;BI_RGB) or 
              (biBitCount&lt;&gt;24) then Error('only true-color BMP supported'); 
{выделяем память под битмэп} 
           Allocate(biWidth,biHeight); 
         end; 
 
         for j:=0 to BI.bmiHeader.biHeight-1 do 
           for i:=0 to BI.bmiHeader.biWidth-1 do 
{Pixels - это property, возвр. указатель на соотв. RGBTriple в битмэпе} 
              Pixels[i,j]^.Tr:=ParrRGBTriple(PF+j*FLineSize+Ofs)^[i]; 
      finally 
        UnmapViewOfFile(PF); 
      end; 
   finally 
     CloseHandle(HM); 
   end; 
  finally 
    FileClose(HF); 
  end; 
end; 
 
{эта функция - реализация Pixels read} 
function TMBitmap.GetPixel(X,Y:integer):PRGB; 
 
begin 
  if (X&gt;=0) and (Xand 
     (Y&gt;=0) and (Ythen Result:=PRGB(PB+(Y)*FLineSize+X*3) 
  else Result:=PRGB(PB); 
end; 
</pre>


<p>Если у вас на форме есть компонент TImage, то можно сделать так:</p>

<pre>
var BMP:TMBitmap; 
    B:TBitmap; 
... 
    BMP.LoadFromFile(..); 
    B:=TBitmap.Create; 
    B.Handle:=BMP.Handle; 
    Image1.Picture.Bitmap:=B; 
</pre>

<p>и загруженный битмэп появится на экране.</p>

<p>Alexander Burnashov</p>
<p>E-mail alex@arta.spb.su</p>
<p>(2:5030/254.36)</p>
