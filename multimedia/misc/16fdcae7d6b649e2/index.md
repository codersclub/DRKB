---
Title: Оптимизация скинов для окошек сложной формы
Author: Бочаров Александр
Date: 01.01.2007
---


Оптимизация скинов для окошек сложной формы
===========================================

::: {.date}
01.01.2007
:::

Автор: Бочаров Александр

Немного предистории: надо было мне создать скиновое окошко. Вроде
несложно, исходников по этому делу везде лежит навалом, бери да делай.
Проблема организовалась в том, что для сложных фигур просчет такого окна
из растра занимает достаточно много времени. А когда окон несколько?
Короче, я решил все это дело написать самостоятельно, причем отказавшись
от таких вещей, как GetPixel() и CombineRgn(). Получилось вроде здорово
и быстро.

Далее следует исходный код с комментариями:

    unit RgnUnit; 
     

     
    interface 
     
    uses 
      Windows, SysUtils, Classes; 
     
    function CreateBitmapRgn(DC : hDC; Bitmap: hBitmap; TransClr: TColorRef): hRgn; 
    { 
    Данная функция создает регион, используя для этого растр Bitmap 
    и исключая из него цвет TransClr. Все расчеты производятся для 
    устройства DC. 
     
    данная функция состоит из двух частей: 
     
    первая часть выделяет память и копирует туда исходное изображение в формате 
    24 бита на точку, без палитры, т.е. фактически в каждых трех байтах 
    данного раздела памяти будет записан цвет точки исходного изображения. 
    Данный формат был выбран из удобства его обработки 
    (нет необходимости создавать палитру), к тому же нет потери качества 
    при конвертации исходного изображения. Однако, теоретически можно использовать 
    любой формат. 
     
    Для выделения памяти под конвертируемое изображение используется функция 
    WinAPI CreateDIBSection. Данная функция выделяет память и создает 
    независмый растр. Для вызова данной функции необходимо заполнить структуру 
    BITMAPINFO, что достаточно не сложно. 
    Внимание! для изображений Windows Bitmap используется разрешение в формате 
    dots per metr (pixels per metr), стандартному разрешению 72dpi соответствует 
    2834dpm. 
     
    Фактически, данную функция можно не использовать, вручную выделив память 
    для последующего переноса исходного изображения. 
     
    Для конвертации и переноса исходного изображения в выделнную память 
    используется функция WinAPI GetDIBits. Функции передаются следуюшие параметры: 
    исходное изображение, количество рядов для переноса, указатель на память, 
    куда следует перенести изображение, структура BITMAPINFO с заполнеными первыми 
    шестью членами (именно здесь задяются параметры для конвертирования 
    изображения). Фактически, данная функция может перевести любой исходный растр 
    в любой необходимый растр. 
     
    вторая чать описываемой функции проходится по области памяти, куда было 
    занесено конвертируемое изображение, отсекает ненужные области и содает регион. 
    Для создания региона используется функция WinAPI ExtCreateRegion. Для вызова 
    данной функции необходимо заполнить структуру RGNDATA, состоящую из структуры 
    RGNDATAHEADER и необходимого количества структур RECT. в Дельфи структура 
    RGNDATA описана так: 
     
      _RGNDATA = record 
        rdh: TRgnDataHeader; 
        Buffer: array[0..0] of CHAR; 
        Reserved: array[0..2] of CHAR; 
      end; 
      RGNDATA = _RGNDATA; 
     
    Скорее всего, поле Reserved было введено программистами Дельфи только для того, 
    чтобы в нее умещался хотя бы один прямоугольник, т.к. в Microsoft Platfrom SDK 
    этого поля нет. Однако, данная структура нам не подходит, т.к. нам необходимо 
    учитывать сразу несколько прямоугольников. Для решения этой задачи приходится 
    выделять память вручную, с учетом RGNDATAHEADER и количества прямоугольников, 
    необходимых нам, заносить туда прямоугольники (после RGNDATAHEADER), 
    создавать указатель на структуру RGNDATA и ставить его на выделнную память. 
     
    Следовательно, придется два раза пройтись по растру: первый раз - для расчета 
    количества прямоугольников, а второй - для уже фактического их занесения 
    в выделенную память. 
     
    Есть несколько способов для избежания двойного прохода растра, но все они 
    имеют свои недостатки и здесь не рассматриваются. В любом случае, даже для 
    больших и сложных изображений эти два прохода достаточно быстры. 
     
    по окнчании работы функции освобождается память, выделенная на конвертируемый 
    растр и структуру RGNDATA. 
    } 
     
    implementation 
     
    //создает регион из растра Bitmap для DC с удалением цвета TransClr 
    //внимание! TColorRef и TColor не одно и тоже. 
    //Для перевода используется функция ColorToRGB(). 
     
    function CreateBitmapRgn(DC: hDC; Bitmap: hBitmap; TransClr: TColorRef): hRgn;
    var
      bmInfo: TBitmap;                //структура BITMAP WinAPI
      W, H: Integer;                  //высота и ширина растра
      bmDIB: hBitmap;                 //дискрептор независимого растра
      bmiInfo: BITMAPINFO;            //структура BITMAPINFO WinAPI
      lpBits, lpOldBits: PRGBTriple;  //указатели на структуры RGBTRIPLE WinAPI
      lpData: PRgnData;               //указатель на структуру RGNDATA WinAPI
      X, Y, C, F, I: Integer;         //переменные циклов
      Buf: Pointer;                   //указатель
      BufSize: Integer;               //размер указателя
      rdhInfo: TRgnDataHeader;        //структура RGNDATAHEADER WinAPI
      lpRect: PRect;                  //указатель на TRect (RECT WinAPI)
    begin
      Result:=0;
      if Bitmap=0 then Exit;          //если растр не задан, выходим
     
      GetObject(Bitmap, SizeOf(bmInfo), @bmInfo);  //узнаем размеры растра 
      W:=bmInfo.bmWidth;                           //используя структуру BITMAP 
      H:=bmInfo.bmHeight; 
      I:=(W*3)-((W*3) div 4)*4;                    //определяем смещение в байтах 
      if I<>0 then I:=4-I; 
     
    //Пояснение: растр Windows Bitmap читается снизу вверх, причем каждая строка 
    //дополняется нулевыми байтами до ее кратности 4. 
    //для 32-х битный растров такой сдвиг делать не надо. 
     
    //заполняем BITMAPINFO для передачи в CreateDIBSection 
     
      bmiInfo.bmiHeader.biWidth:=W;             //ширина 
      bmiInfo.bmiHeader.biHeight:=H;            //высота 
      bmiInfo.bmiHeader.biPlanes:=1;            //всегда 1 
      bmiInfo.bmiHeader.biBitCount:=24;         //три байта на пиксель 
      bmiInfo.bmiHeader.biCompression:=BI_RGB;  //без компрессии 
      bmiInfo.bmiHeader.biSizeImage:=0;         //размер не знаем, ставим в ноль 
      bmiInfo.bmiHeader.biXPelsPerMeter:=2834;  //пикселей на метр, гор.
      bmiInfo.bmiHeader.biYPelsPerMeter:=2834;  //пикселей на метр, верт.
      bmiInfo.bmiHeader.biClrUsed:=0;           //палитры нет, все в ноль 
      bmiInfo.bmiHeader.biClrImportant:=0;      //то же 
      bmiInfo.bmiHeader.biSize:=SizeOf(bmiInfo.bmiHeader); //размер структруы 
      bmDIB:=CreateDIBSection(DC, bmiInfo, DIB_RGB_COLORS, 
                              Pointer(lpBits), 0, 0); 
    //создаем независимый растр WxHx24, без палитры, в указателе lpBits получаем 
    //адрес первого байта этого растра. bmDIB - дискрептор растра 
     
    //заполняем первые шесть членов BITMAPINFO для передачи в GetDIBits 
     
      bmiInfo.bmiHeader.biWidth:=W;             //ширина 
      bmiInfo.bmiHeader.biHeight:=H;            //высота 
      bmiInfo.bmiHeader.biPlanes:=1;            //всегда 1
      bmiInfo.bmiHeader.biBitCount:=24;         //три байта на пиксель
      bmiInfo.bmiHeader.biCompression:=BI_RGB;  //без компресси 
      bmiInfo.bmiHeader.biSize:=SizeOf(bmiInfo.bmiHeader); //размер структуры 
      GetDIBits(DC, Bitmap, 0, H, lpBits, bmiInfo, DIB_RGB_COLORS); 
    //конвертируем исходный растр в наш с его копированием по адресу lpBits 
     
      lpOldBits:=lpBits;  //запоминаем адрес lpBits
     
    //первый проход - подсчитываем число прямоугольников, необходимых для
    //создания региона
      C:=0;                         //сначала ноль
      for Y:=H-1 downto 0 do begin  //проход снизу вверх
        X:=0;
        while X<W do begin             //от 0 до ширины-1
    //пропускаем прзрачный цвет, увеличивая координату и указатель
          while (X<W) and (RGB(lpBits.rgbtRed,lpBits.rgbtGreen,lpBits.rgbtBlue)=TransClr) do begin
            Inc(lpBits);
            X:=X+1;
          end;
    //если нашли не прозрачный цвет, то считаем, сколько точек в ряду он идет
          if (X<W) and (RGB(lpBits.rgbtRed,lpBits.rgbtGreen,lpBits.rgbtBlue)<>TransClr) then begin
            while (X<W) and (RGB(lpBits.rgbtRed,lpBits.rgbtGreen,lpBits.rgbtBlue)<>TransClr) do begin
              Inc(lpBits);
              X:=X+1;
            end;
            C:=C+1;  //увиличиваем счетчик прямоугольников
          end;
        end;
    //ряд закончился, необходимо увеличить указатель до кратности 4
        PChar(lpBits):=PChar(lpBits)+I;
      end;
     
      lpBits:=lpOldBits;  //восстанавливаем значение lpBits
     
    //Заполняем структуру RGNDATAHEADER
      rdhInfo.iType:=RDH_RECTANGLES;             //будем использовать прямоугольники
      rdhInfo.nCount:=C;                         //их количество
      rdhInfo.nRgnSize:=0;                       //размер выделяем памяти не знаем
      rdhInfo.rcBound:=Rect(0, 0, W, H);         //размер региона
      rdhInfo.dwSize:=SizeOf(rdhInfo);           //размер структуры
     
    //выделяем память для струтуры RGNDATA:
    //сумма RGNDATAHEADER и необходимых на прямоугольников
      BufSize:=SizeOf(rdhInfo)+SizeOf(TRect)*C;
      GetMem(Buf, BufSize);
      lpData:=Buf;             //ставим указатель на выделенную память
      lpData.rdh:=rdhInfo;     //заносим в память RGNDATAHEADER
     
    //Заполдяенм память прямоугольниками
      lpRect:=@lpData.Buffer;  //первый прямоугольник
      for Y:=H-1 downto 0 do begin
        X:=0;
        while X<W do begin
          while (X<W) and (RGB(lpBits.rgbtRed,lpBits.rgbtGreen,lpBits.rgbtBlue)=TransClr) do begin
            Inc(lpBits);
            X:=X+1;
          end;
          if (X<W) and (RGB(lpBits.rgbtRed,lpBits.rgbtGreen,lpBits.rgbtBlue)<>TransClr) then begin
            F:=X;
            while (X<W) and (RGB(lpBits.rgbtRed,lpBits.rgbtGreen,lpBits.rgbtBlue)<>TransClr) do begin
              Inc(lpBits);
              X:=X+1;
            end;
            lpRect^:=Rect(F, Y, X, Y+1);  //заносим координаты
            Inc(lpRect);                  //переходим к следующему
          end;
        end;
        PChar(lpBits):=PChar(lpBits)+I;
      end;
     
    //после окночания заполнения структуры RGNDATA можно создавать регион.
    //трансформации нам не нужны, ставим в nil, указываем размер
    //созданной структуры и ее саму.
      Result:=ExtCreateRegion(nil, BufSize, lpData^);  //создаем регион
     
      FreeMem(Buf, BufSize);  //теперь структура RGNDATA больше не нужна, удаляем
      DeleteObject(bmDIB);    //созданный растр тоже удаляем
    end;
     
    end.

Взято из <https://forum.sources.ru>

Код исправлен Петровичем

Взято с Vingrad.ru <https://forum.vingrad.ru>
