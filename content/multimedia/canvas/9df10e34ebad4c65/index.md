---
Title: Работа с изображением в памяти
Date: 01.01.2007
---


Работа с изображением в памяти
==============================

::: {.date}
01.01.2007
:::

Вот кусок одного моего класса, в котором есть две интересные вещицы -

проецирование файлов в память и работа с битмэпом в памяти через
указатель.

    type 
       TarrRGBTriple=array[byte] of TRGBTriple; 
       ParrRGBTriple=^TarrRGBTriple; 
     
     
    {организует битмэп размером SX,SY;true_color} 
    procedure TMBitmap.Allocate(SX,SY:integer); 
    var DC:HDC; 
    begin 
      if BM<>0 then DeleteObject(BM);   {удаляем старый битмэп, если был} 
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
     
        if (biWidth or biHeight)<>0 then 
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
     
      if HF<0 then Error('open file '''+FileName+''''); 
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
     
             if PBitmapFileHeader(PF)^.bfType<>$4D42 then  Error('file format'); 
             Ofs:=PBitmapFileHeader(PF)^.bfOffBits; 
             with PBitmapInfo(PF+sizeof(TBitmapFileHeader))^.bmiHeader do 
             begin 
               if (biSize<>40) or (biPlanes<>1) then Error('file format'); 
               if (biCompression<>BI_RGB) or 
                  (biBitCount<>24) then Error('only true-color BMP supported'); 
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
      if (X>=0) and (Xand 
         (Y>=0) and (Ythen Result:=PRGB(PB+(Y)*FLineSize+X*3) 
      else Result:=PRGB(PB); 
    end; 

Если у вас на форме есть компонент TImage, то можно сделать так:

    var BMP:TMBitmap; 
        B:TBitmap; 
    ... 
        BMP.LoadFromFile(..); 
        B:=TBitmap.Create; 
        B.Handle:=BMP.Handle; 
        Image1.Picture.Bitmap:=B; 

и загруженный битмэп появится на экране.

Alexander Burnashov

E-mail alex\@arta.spb.su

(2:5030/254.36)
