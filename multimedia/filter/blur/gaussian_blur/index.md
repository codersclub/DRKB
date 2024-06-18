---
Title: Получение Gaussian Blur
Author: Den is Com
Date: 01.01.2007
---


Получение Gaussian Blur
=======================

Вариант 2:

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

Ну вот, добрались и до фильтров. В неформальных испытаниях этот код
оказался вдвое быстрее, чем это делает Adobe Photoshop. Мне кажется есть
множество фильтров, которые можно переделать или оптимизировать для
быстроты обработки изображений.

Ядро гауссовой функции `exp(-(x^2 + y^2))` есть разновидность формулы
`f(x)*g(y)`, которая означает, что мы можем выполнить двумерную свертку,
делая последовательность одномерных сверток - сначала мы свертываем
каждую строчку изображения, затем - каждую колонку. Хороший повод для
ускорения (`N^2` становится `N*2`). Любая свертка требует некоторого место
для временного хранения результатов - ниже в коде программа BlurRow как
раз распределяет и освобождает память для каждой колонки. Вероятно это
должно ускорить обработку изображения, правда не ясно насколько.

Поле "size" в записи TKernel ограничено значением 200. Фактически,
если вы хотите использовать еще больший радиус, это не вызовет проблем -
попробуйте со значениями radius = 3, 5 или другими. Для большого
количества данных методы свертки на поверку оказываются эффективнее
преобразований Фурье (как показали опыты).

Еще один комментарий все же необходим: гауссово размывание имеет одно
магическое свойство, а именно - вы можете сначала размыть каждую строчку
(применить фильтр), затем каждую колонку - фактически получается
значительно быстрее, чем двумерная свертка.

Во всяком случае вы можете сделать так:

    unit GBlur2;
    
    interface
     
    uses
      Windows, Graphics;
     
    type
      PRGBTriple = ^TRGBTriple;
      TRGBTriple = packed record
        b: byte; //легче для использования чем типа rgbtBlue...
        g: byte;
        r: byte;
      end;
     
      PRow = ^TRow;
      TRow = array[0..1000000] of TRGBTriple;
     
      PPRows = ^TPRows;
      TPRows = array[0..1000000] of PRow;
     
    const
      MaxKernelSize = 100;
     
    type
     
      TKernelSize = 1..MaxKernelSize;
     
      TKernel = record
        Size: TKernelSize;
        Weights: array[-MaxKernelSize..MaxKernelSize] of single;
      end;
      //идея заключается в том, что при использовании TKernel мы игнорируем
      //Weights (вес), за исключением Weights в диапазоне -Size..Size.
     
    procedure GBlur(theBitmap: TBitmap; radius: double);
     
    implementation
     
    uses
      SysUtils;
     
    procedure MakeGaussianKernel(var K: TKernel;
                                 radius: double;
                                 MaxData, DataGranularity: double);
    //Делаем K (гауссово зерно) со среднеквадратичным отклонением = radius.
    //Для текущего приложения мы устанавливаем переменные MaxData = 255,
    //DataGranularity = 1. Теперь в процедуре установим значение
    //K.Size так, что при использовании K мы будем игнорировать Weights (вес)
    //с наименее возможными значениями. (Малый размер нам на пользу,
    //поскольку время выполнения напрямую зависит от
    //значения K.Size.)
    var
      j: integer;
      temp, delta: double;
      KernelSize: TKernelSize;
    begin
     
      for j := Low(K.Weights) to High(K.Weights) do
      begin
        temp := j / radius;
        K.Weights[j] := exp(-temp * temp / 2);
      end;
     
      //делаем так, чтобы sum(Weights) = 1:
     
      temp := 0;
      for j := Low(K.Weights) to High(K.Weights) do
        temp := temp + K.Weights[j];
      for j := Low(K.Weights) to High(K.Weights) do
        K.Weights[j] := K.Weights[j] / temp;
     
      //теперь отбрасываем (или делаем отметку "игнорировать"
      //для переменной Size) данные, имеющие относительно небольшое значение -
      //это важно, в противном случае смазавание происходим с малым радиусом и
      //той области, которая "захватывается" большим радиусом...
     
      KernelSize := MaxKernelSize;
      delta := DataGranularity / (2 * MaxData);
      temp := 0;
      while (temp < delta) and (KernelSize > 1) do
      begin
        temp := temp + 2 * K.Weights[KernelSize];
        dec(KernelSize);
      end;
     
      K.Size := KernelSize;
     
      //теперь для корректности возвращаемого результата проводим ту же
      //операцию с K.Size, так, чтобы сумма всех данных была равна единице:
     
      temp := 0;
      for j := -K.Size to K.Size do
        temp := temp + K.Weights[j];
      for j := -K.Size to K.Size do
        K.Weights[j] := K.Weights[j] / temp;
     
    end;
    
    function TrimInt(Lower, Upper, theInteger: integer): integer;
    begin
     
      if (theInteger <= Upper) and (theInteger >= Lower) then
        result := theInteger
      else if theInteger > Upper then
        result := Upper
      else
        result := Lower;
    end;
    
    function TrimReal(Lower, Upper: integer; x: double): integer;
    begin
     
      if (x < upper) and (x >= lower) then
        result := trunc(x)
      else if x > Upper then
        result := Upper
      else
        result := Lower;
    end;
    
    procedure BlurRow(var theRow: array of TRGBTriple; K: TKernel; P: PRow);
    var
      j, n, LocalRow: integer;
      tr, tg, tb: double; //tempRed и др.
     
      w: double;
    begin
     
      for j := 0 to High(theRow) do
     
      begin
        tb := 0;
        tg := 0;
        tr := 0;
        for n := -K.Size to K.Size do
        begin
          w := K.Weights[n];
     
          //TrimInt задает отступ от края строки...
     
          with theRow[TrimInt(0, High(theRow), j - n)] do
          begin
            tb := tb + w * b;
            tg := tg + w * g;
            tr := tr + w * r;
          end;
        end;
        with P[j] do
        begin
          b := TrimReal(0, 255, tb);
          g := TrimReal(0, 255, tg);
          r := TrimReal(0, 255, tr);
        end;
      end;
     
      Move(P[0], theRow[0], (High(theRow) + 1) * Sizeof(TRGBTriple));
    end;
     
    procedure GBlur(theBitmap: TBitmap; radius: double);
    var
      Row, Col: integer;
      theRows: PPRows;
      K: TKernel;
      ACol: PRow;
      P: PRow;
    begin
      if (theBitmap.HandleType <> bmDIB) or (theBitmap.PixelFormat <> pf24Bit) then
     
        raise
          exception.Create('GBlur может работать только с 24-битными изображениями');
     
      MakeGaussianKernel(K, radius, 255, 1);
      GetMem(theRows, theBitmap.Height * SizeOf(PRow));
      GetMem(ACol, theBitmap.Height * SizeOf(TRGBTriple));
     
      //запись позиции данных изображения:
      for Row := 0 to theBitmap.Height - 1 do
     
        theRows[Row] := theBitmap.Scanline[Row];
     
      //размываем каждую строчку:
      P := AllocMem(theBitmap.Width * SizeOf(TRGBTriple));
      for Row := 0 to theBitmap.Height - 1 do
     
        BlurRow(Slice(theRows[Row]^, theBitmap.Width), K, P);
     
      //теперь размываем каждую колонку
      ReAllocMem(P, theBitmap.Height * SizeOf(TRGBTriple));
      for Col := 0 to theBitmap.Width - 1 do
      begin
        //- считываем первую колонку в TRow:
     
        for Row := 0 to theBitmap.Height - 1 do
          ACol[Row] := theRows[Row][Col];
     
        BlurRow(Slice(ACol^, theBitmap.Height), K, P);
     
        //теперь помещаем обработанный столбец на свое место в данные изображения:
     
        for Row := 0 to theBitmap.Height - 1 do
          theRows[Row][Col] := ACol[Row];
      end;
     
      FreeMem(theRows);
      FreeMem(ACol);
      ReAllocMem(P, 0);
    end;
     
    end.

Должно работать, если только вы не удалите некоторый код вместе с
глупыми коментариями. Для примера:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      b: TBitmap;
    begin
      if not openDialog1.Execute then
        exit;
     
      b := TBitmap.Create;
      b.LoadFromFile(OpenDialog1.Filename);
      b.PixelFormat := pf24Bit;
      Canvas.Draw(0, 0, b);
      GBlur(b, StrToFloat(Edit1.text));
      Canvas.Draw(b.Width, 0, b);
      b.Free;
    end;

Имейте в виду, что 24-битные изображения при системной 256-цветной
палитре требуют некоторых дополнительных хитростей, так как эти
изображения не только выглядят в таком случае немного "странными", но
и серьезно нарушают работу фильтра.


------------------------------------------------------------------------

Вариант 2:

Author: Den is Com

Source: <https://delphiworld.narod.ru>

**Гауссово размывание (Gaussian Blur) в Delphi (продолжение) - Создание тени у метки**

Данный метод позволяет создавать тень у текстовых меток TLabel. Не
требует лазить в Photoshop и что-то ваять там - тень рисуется
динамически, поэтому и объём программы не раздувает. Создание тени
присходит в фоновом режиме, во время "простоя" процессора.

Пример использования:

    ShowFade(CaptionLabel);
    //или
    ShowFadeWithParam(CaptionLabel,3,3,2,clGray);

Blur.pas

    unit blur;
     
    interface
     
    uses
     
      Classes, graphics, stdctrls, gblur2;
    const
      add_width = 4;
     
      add_height = 5;
    type
     
      TBlurThread = class(TThread)
      private
        { Private declarations }
        text_position: Integer;
        FadeLabel: TLabel;
        Temp_Bitmap: TBitmap;
     
        procedure ShowBlur;
        procedure SetSize;
      protected
        F_width, F_X, F_Y: Integer;
        F_color: TColor;
        procedure Execute; override;
      public
     
        constructor Create(Sender: TLabel; Fade_width: integer; Fade_X: Integer;
          Fade_Y: Integer; Fade_color: TColor);
        destructor Destroy;
     
      end;
    procedure ShowFade(Sender: TLabel);
    procedure ShowFadeWithParam(Sender: TLabel; Fade_width: integer; Fade_X:
      Integer; Fade_Y: Integer; Fade_color: TColor);
     
    implementation
     
    procedure ShowFadeWithParam(Sender: TLabel; Fade_width: integer; Fade_X:
      Integer; Fade_Y: Integer; Fade_color: TColor);
    var
      SlowThread: TBlurThread;
    begin
      SlowThread := TBlurThread.Create(Sender, Fade_width, Fade_X, Fade_Y,
        Fade_color);
      SlowThread.Priority := tpIdle;
      SlowThread.Resume;
    end;
     
    procedure ShowFade;
    var
      SlowThread: TBlurThread;
    begin
      SlowThread := TBlurThread.Create(Sender, 3, 3, 3, clBlack);
      SlowThread.Priority := tpIdle;
      //SlowThread.Priority:=tpLowest;
      //SlowThread.Priority:=tpTimeCritical;
      SlowThread.Resume;
    end;
     
    constructor TBlurThread.Create(Sender: TLabel; Fade_width: integer; Fade_X:
      Integer; Fade_Y: Integer; Fade_color: TColor);
    begin
      Temp_Bitmap := TBitmap.Create;
      Temp_Bitmap.Canvas.Font := Sender.Font;
      FadeLabel := Sender;
      F_width := Fade_width;
      F_X := Fade_X;
      F_Y := Fade_Y;
      F_color := Fade_color;
      inherited Create(True);
    end;
     
    destructor TBlurThread.Destroy;
    begin
      Temp_Bitmap.Free;
      inherited Destroy;
    end;
     
    procedure TBlurThread.ShowBlur;
    begin
      FadeLabel.Canvas.Draw(text_position + F_X, F_Y, Temp_Bitmap);
      FadeLabel.Canvas.TextOut(text_position, 0, FadeLabel.Caption);
    end;
     
    procedure TBlurThread.SetSize;
    begin
      if FadeLabel.Width < (Temp_Bitmap.Canvas.TextWidth(FadeLabel.Caption) + F_width
        + F_X {add_width}) then
      begin
        FadeLabel.Width := Temp_Bitmap.Canvas.TextWidth(FadeLabel.Caption) + F_width
          + F_X {add_width};
        FadeLabel.Tag := 2;
      end
      else
        FadeLabel.Tag := 0;
     
      if FadeLabel.Height < (Temp_Bitmap.Canvas.TextHeight(FadeLabel.Caption) +
        F_width + F_Y {add_height}) then
      begin
        FadeLabel.Height := Temp_Bitmap.Canvas.TextHeight(FadeLabel.Caption) +
          F_width + F_Y {add_height};
        FadeLabel.Tag := 1;
      end
      else if FadeLabel.Tag <> 2 then
        FadeLabel.Tag := 0;
     
    end;
     
    { TBlurThread }
     
    procedure TBlurThread.Execute;
    begin
     
      { Place thread code here }
      Synchronize(SetSize);
     
      if FadeLabel.Tag = 0 then
      begin
        Temp_Bitmap.Width := FadeLabel.Width;
        Temp_Bitmap.Height := FadeLabel.Height;
        Temp_Bitmap.Canvas.Brush.Color := FadeLabel.Color;
        Temp_Bitmap.Canvas.FillRect(FadeLabel.ClientRect);
        Temp_Bitmap.Canvas.Font.Color := F_color; //clBlack
     
        if FadeLabel.Alignment = taRightJustify then
          text_position := FadeLabel.Width -
            Temp_Bitmap.Canvas.TextWidth(FadeLabel.Caption) - F_width - F_X {add_width}
        else if FadeLabel.Alignment = taCenter then
          text_position := (FadeLabel.Width -
            Temp_Bitmap.Canvas.TextWidth(FadeLabel.Caption) - F_width - F_X
            {add_width}) div 2
        else
          text_position := 0;
     
        Temp_Bitmap.Canvas.TextOut(0, 0, FadeLabel.Caption);
        Temp_Bitmap.PixelFormat := pf24Bit;
        GBlur(Temp_Bitmap, F_width);
        //Temp_Bitmap.SaveToFile('a.bmp');
        Synchronize(ShowBlur);
      end;
     
    end;
     
    end.

