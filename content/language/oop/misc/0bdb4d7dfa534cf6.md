Клонирование объектов
=====================

::: {.date}
01.01.2007
:::

Клонирование объектов.

Создать копию объекта в Delphi очень просто. Конвертируем объект в
текст, а затем - обратно. При этом будут продублированы все свойства,
кроме ссылок на обработчики событий. Для преобразования компонента в
файл и обратно нам понадобятся функции потоков
WriteComponent(TComponent) и ReadComponent(TComponent). При этом в поток
записывается двоичный ресурс. Последний с помощью функции
ObjectBinaryToText можно преобразовать в текст.\

Создадим на их основе функции преобразования:

    function ComponentToString(Component: TComponent): string; 
    var 
      ms: TMemoryStream; 
      ss: TStringStream; 
    begin 
      ss := TStringStream.Create(' '); 
      ms := TMemoryStream.Create; 
      try 
        ms.WriteComponent(Component); 
        ms.position := 0; 
        ObjectBinaryToText(ms, ss); 
        ss.position := 0; 
        Result := ss.DataString; 
      finally 
        ms.Free; 
        ss.free; 
      end; 
    end; 
     
    procedure StringToComponent(Component: TComponent; Value: string); 
    var 
      StrStream:TStringStream; 
      ms: TMemoryStream; 
    begin 
      StrStream := TStringStream.Create(Value); 
      try 
        ms := TMemoryStream.Create; 
        try 
          ObjectTextToBinary(StrStream, ms); 
          ms.position := 0; 
          ms.ReadComponent(Component); 
        finally 
          ms.Free; 
        end; 
      finally 
        StrStream.Free; 
      end; 
    end;

С помощью пары этих функций мы можем преобразовать любой компонент в
текст, а затем проинициализировать другой компонент того же класса этими
данными.\

Ниже приведен ресурс формы с одной кнопкой и текст обработчика нажатия
на эту кнопку.

    object Form1: TForm1 
      Left = 262 
      Top = 129 
      Width = 525 
      Height = 153 
      Caption = 'Form1' 
      Color = clBtnFace 
      Font.Charset = DEFAULT_CHARSET 
      Font.Color = clWindowText 
      Font.Height = -11 
      Font.Name = 'MS Sans Serif' 
      Font.Style = [] 
      OldCreateOrder = False 
      Scaled = False 
      PixelsPerInch = 96 
      TextHeight = 13 
      object Button1: TButton 
        Left = 16 
        Top = 32 
        Width = 57 
        Height = 49 
        Caption = 'Caption' 
        TabOrder = 0 
        OnClick = Button1Click 
      end 
    end 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      Button: TButton; 
      OldName: string; 
    begin 
      Button := TButton.Create(self); 
     
      //...сохраняем имя компонента 
      OldName := (Sender as TButton).Name; 
     
      //...стираем имя компонента, чтобы избежать конфликта имен.
      //...После этого Button1 станет = nil. 
      (Sender as TButton).Name := ''; 
     
      //...преобразуем в текст и обратно 
      StringToComponent( Button, ComponentToString(Sender as TButton) ); 
     
      //...дадим компоненту уникальное(?) имя 
      Button.Name := 'Button' + IntToStr(random(1000)); 
     
      //...вернем исходному компоненту имя.
      //...После этого Button1 станет снова указывать на объект. 
      (Sender as TButton).Name := OldName; 
     
      //...размещаем новую кнопку справа от исходной 
      Button.parent := self; 
      Button1.Tag := Button1.Tag + 1; 
      Button.Left := Button.Left + Button.Width * Button1.Tag + 1; 
    end; 

Приведенный метод не дублирует указатели на обработчики событий. Однако,
если таким образом дублировать формы, то все дочерние компоненты и все
обработчики сохранятся.

Составление статьи: Андрей Чудин, ЦПР ТД Библио-Глобус

Взято из [http://delphi.chertenok.ru](https://delphi.chertenok.ru)
