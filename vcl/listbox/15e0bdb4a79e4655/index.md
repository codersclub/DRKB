---
Title: Как вставить растровое изображение в компонент TListBox?
Date: 01.01.2007
---


Как вставить растровое изображение в компонент TListBox?
========================================================

::: {.date}
01.01.2007
:::

Для этого необходимо установить в инспекторе объектов поле Style в
lbOwnerDrawFixed, при фиксированной высоте строки, или в
lbOwnerDrawVariable, при переменной, и установить собственный обработчик
события для OnDrawItem. В этом обработчике и надо рисовать растровое
изображение.

Пример:

Рисуются изображения размером 32\*16 (размер стандартного глифа для
Delphi). Очень полезно при поиске нужного изображения для кнопок!

Установить в инспекторе объектов для ListBox поле ItemHeight = 19, а
поле Color = clBtnFace.

    { Загрузить список файлов в ListBox1 при нажатии на кнопку Load (например)}
    procedure TForm1.bLoadClick(Sender: TObject);
    VAR S : String; 
    begin 
      ListBox1.Clear; {чистим список}
      S := '*.bmp'#0; {задаем шаблон}
      ListBox1.Perform(LB_DIR, DDL_ReadWrite, Longint(@S[1])); {заполняем список} 
    end; 
              ............ 
     
    {Отобразить изображения и имена файлов в ListBox}
    procedure TForm1.ListBox1DrawItem(Control: TWinControl; Index: Integer;
      Rect: TRect; State: DrawState);
    var
      Bitmap: TBitmap;
      Offset: Integer;
      BMPRect: TRect;
    begin
      with (Control as TListBox).Canvas do
        begin
          FillRect(Rect);
          Bitmap := TBitmap.Create;
          Bitmap.LoadFromFile(ListBox1.Items[Index]);
          Offset := 0;
          if Bitmap <> nil then
            begin
              BMPRect := Bounds(Rect.Left + 2, Rect.Top + 2,
                (Rect.Bottom - Rect.Top - 2) * 2, Rect.Bottom - Rect.Top - 2);
          {StretchDraw(BMPRect, Bitmap); Можно просто нарисовать, но лучше сначала убрать фон}
              BrushCopy(BMPRect, Bitmap, Bounds(0, 0, Bitmap.Width, Bitmap.Height),
                Bitmap.Canvas.Pixels[0, Bitmap.Height - 1]);
              Offset := (Rect.Bottom - Rect.Top + 1) * 2;
            end;
          TextOut(Rect.Left + Offset, Rect.Top, ListBox1.Items[Index]);
          Bitmap.Free;
        end;
    end;

Данный пример работает медленно, но оптимизация, для ускорения, вызвала
бы трудность в понимании общего принципа его работы.

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

Сначала создайте bmp-файл, который вы будете помещать около каждого
элемента списка, в примере это \'c:\\file.bmp\'. Для создания файла
можете воспользоваться специальной графической утилитой ImageEditor,
которая входит в пакет Delphi. Желательно, чтобы размер файлы был 16х16.
После этого вынесите на форму компонент TListBox. Его свойство Style
установите в lbOwnerDrawVariable - это позволит нам прорисовывать каждый
элемент списка самостоятельно.

Далее объявляем переменную:

var

Bit: TBitmap;

После этого задаём обработчику события OnDrawItem следующий вид:

    procedure TForm1.ListBox1DrawItem(Control: TWinControl; index: Integer;
    Rect: TRect; State: TOwnerDrawState);
    var
      cc: TCanvas;
    begin
      cc:=(Control as TListBox).Canvas;
      cc.FillRect(rect);
      cc.Draw(Rect.Left+Rect.Right-16,Rect.Top,Bit);
      cc.TextOut(Rect.Left,Rect.Top,ListBox1.Items[index]);
    end;

а обработчику события OnMeasureItem такой:

    procedure TForm1.ListBox1MeasureItem(Control: TWinControl;
    index: Integer; var Height: Integer);
    begin
      Height := 16;
    end;

По созданию окна создаёт Bitmap и загружаем в него данные из файла:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Bit := TBitmap.Create;
      Bit.LoadFromFile('c:\file.bmp');
    end;

По уничтожению окна - уничтожаем Bitmap

    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      Bit.Destroy;
    end;

Взято с <https://delphiworld.narod.ru>
