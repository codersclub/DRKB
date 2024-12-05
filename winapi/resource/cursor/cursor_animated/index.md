---
Title: Как работать с анимированными курсорами?
Author: Nomadic 
Date: 01.01.2007
---

Как работать с анимированными курсорами?
========================================

Вариант 1:

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

Ответ:

Чтобы использовать анимированный курсор, у вас есть несколько вариантов: загрузить его из файла (используя LoadImage или LoadCursorFromFile), загрузить его из ресурса (используя LoadCursor) или даже создать курсор во время выполнения (используя CreateCursor).

Примечание:

Вам следует реализовать пользовательские курсоры как ресурсы. Вместо того чтобы создавать курсоры во время выполнения, используйте функцию LoadCursor, LoadCursorFromFile или LoadImage, чтобы избежать зависимости от устройства, упростить локализацию и позволить приложениям совместно использовать дизайн курсора.

**Загрузка курсора из файла**

Самый простой способ загрузить курсор из файла — использовать LoadCursorFromFile.

Эта функция возвращает дескриптор загруженного курсора, который вы должны назначить массиву Cursors вашего приложения.

    var
      hCur: HCURSOR;
     
    begin
      // Load the cursor from file
      hCur := LoadCursorFromFile(PChar('path_to_my_cursor'));
      // Assign the loaded cursor to application Cursors array. (This cursor will ave the
      // number 1 assigned to it
      // Remember that predefined cursors start at a negative index, and user defined
      // custom cursors are assigned positive indexes.
      Screen.Cursors[1] := hCur;
     
      // Use the cursor as you would use a built-in cursor.
      Screen.Cursor := 1;
    end;

Вы также можете использовать LoadImage вместо LoadCursorFromFile следующим образом:


    hCur := LoadImage(0, PChar(PChar('path_to_my_cursor')),
                      IMAGE_CURSOR, 0, 0,
                      LR_DEFAULTSIZE or LR_LOADFROMFILE);

**Загрузка курсора из ресурса**

Перед загрузкой курсора из ресурса необходимо создать файл ресурса с загружаемым курсором.

Для этого создайте файл myResources.rc, в который поместите следующее


    #define ANICURSOR 21
    myCursor ANICURSOR "path_to_my_cursor"

Поскольку компилятор ресурсов Borland не понимает тип ресурса ANICURSOR, вам придется использовать числовой идентификатор (21).

Скомпилируйте файл ресурсов с помощью "brcc32 myResources.rc" и включите его в модуль, в который вы будете загружать курсор, используя {$R myResources.res}

Теперь вам просто нужно загрузить курсор из ресурса, а не из файла, используя:


    hCur := LoadCursor(HInstance, PChar('myCursor'));

Помните, что HInstance содержит дескриптор экземпляра приложения или библиотеки, предоставляемый Windows. Эта переменная очень важна, поскольку она используется многими API Windows, которые работают с текущими ресурсами приложения.

**Создание курсора во время выполнения**

Еще один способ использования курсора — это создание его во время выполнения. Зачем вам это делать?

Я не знаю, это ваш выбор. Я сомневаюсь, что вы когда-либо будете создавать свои курсоры во время выполнения, в любом случае, вот способ, как это сделать.

**Определение карты курсора**


    const
      // Yin cursor AND bitmask
      ANDmaskCursor: array[0..127] of byte = (
        $FF, $FC, $3F, $FF, $FF, $C0, $1F, $FF,
        $FF, $00, $3F, $FF, $FE, $00, $FF, $FF,
        $F7, $01, $FF, $FF, $F0, $03, $FF, $FF,
        $F0, $03, $FF, $FF, $E0, $07, $FF, $FF,
        $C0, $07, $FF, $FF, $C0, $0F, $FF, $FF,
        $80, $0F, $FF, $FF, $80, $0F, $FF, $FF,
        $80, $07, $FF, $FF, $00, $07, $FF, $FF,
        $00, $03, $FF, $FF, $00, $00, $FF, $FF,
        $00, $00, $7F, $FF, $00, $00, $1F, $FF,
        $00, $00, $0F, $FF, $80, $00, $0F, $FF,
        $80, $00, $07, $FF, $80, $00, $07, $FF,
        $C0, $00, $07, $FF, $C0, $00, $0F, $FF,
        $E0, $00, $0F, $FF, $F0, $00, $1F, $FF,
        $F0, $00, $1F, $FF, $F8, $00, $3F, $FF,
        $FE, $00, $7F, $FF, $FF, $00, $FF, $FF,
        $FF, $C3, $FF, $FF, $FF, $FF, $FF, $FF
        );
     
      // Yin cursor XOR bitmask
      XORmaskCursor: array[0..127] of byte = (
        $00, $00, $00, $00, $00, $03, $C0, $00,
        $00, $3F, $00, $00, $00, $FE, $00, $00,
        $0E, $FC, $00, $00, $07, $F8, $00, $00,
        $07, $F8, $00, $00, $0F, $F0, $00, $00,
        $1F, $F0, $00, $00, $1F, $E0, $00, $00,
        $3F, $E0, $00, $00, $3F, $E0, $00, $00,
        $3F, $F0, $00, $00, $7F, $F0, $00, $00,
        $7F, $F8, $00, $00, $7F, $FC, $00, $00,
        $7F, $FF, $00, $00, $7F, $FF, $80, $00,
        $7F, $FF, $E0, $00, $3F, $FF, $E0, $00,
        $3F, $C7, $F0, $00, $3F, $83, $F0, $00,
        $1F, $83, $F0, $00, $1F, $83, $E0, $00,
        $0F, $C7, $E0, $00, $07, $FF, $C0, $00,
        $07, $FF, $C0, $00, $01, $FF, $80, $00,
        $00, $FF, $00, $00, $00, $3C, $00, $00,
        $00, $00, $00, $00, $00, $00, $00, $00
        );    

затем создайте курсор

    hCur := CreateCursor(HInstance, 19, 2, 32, 32,
                         @ANDmaskCursor, @XORmaskCursor);


------------------------------------------------------------------------

Вариант 2:

Во первых, необходимо получить handle курсора, а затем определить его в
массиве курсоров компонента TScreen. Индексы предопределенных курсоров
системы отрицательны, пользователь может определить курсор, индекс
которого положителен.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      h: THandle;
    begin
      h := LoadImage(0, 'C:\TheWall\Magic.ani', IMAGE_CURSOR, 0, 0, LR_DEFAULTSIZE or LR_LOADFROMFILE);
      if h = 0 then
        ShowMessage('Cursor not loaded')
      else
        begin
          Screen.Cursors[1] := h;
          Form1.Cursor := 1;
        end;
    end;

------------------------------------------------------------------------

Вариант 3:

Author: Nomadic 

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    const
      crMyCursor = 1;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      // Загружаем курсор. Единственный способ для этого
      Screen.Cursors[crMyCursor] :=
        LoadCursorFromFile('c:\mystuff\mycursor.ani');
     
      // Используем курсор на форме
      Cursor := crMyCursor;
    end;

------------------------------------------------------------------------

Вариант 4:

     procedure TForm1.FormCreate(Sender: TObject);
     begin
       Screen.Cursors[crMyCursor] := LoadCursorFromFile('c:\mystuff\mycursor.ani');
       Cursor := crMyCursor;
     end;
     
     
------------------------------------------------------------------------

Вариант 5:

Author: Blodgett

Source: <https://www.swissdelphicenter.ch>

     {*****************************************************************}
     { by Blodgett}
     
     Const
       CURSOR_HOURGLASS = 1;
     {...}
     
     procedure TForm1.LoadCursors;
     var
       h : THandle;
     begin
       if FileExists('..\Images\YourAnimagedCursor.ani') then
       begin
         h := LoadImage(0,
                '..\Images\YourAnimatedCursor.ani',
                IMAGE_CURSOR,
                0,
                0,
                LR_DEFAULTSIZE or
                LR_LOADFROMFILE);
     
         if h <> 0 then
           Screen.Cursors[1] := h;
       end;
     end;
     
     procedure TForm1.BitBtn1Click(Sender: TObject);
     var
      FCurrentCursor: Integer;
     begin
      //1st - Load Cursors Information 
      LoadCursors;
      //2nd - Set FCurrentCursor variable 
      //      to current screen cursor. 
      FCurrentCursor := Screen.Cursor;
      //3rd - Set Screen.Cursor to your CONST Value. 
      //      this is your animated cursor. 
      Screen.Cursor := CURSOR_HOURGLASS;
      //4th - Do something ... 
      sleep(2000);
      //5th - Set Screen.Cursor to original cursor. 
      Screen.Cursor := FCurrentCursor;
     end;

