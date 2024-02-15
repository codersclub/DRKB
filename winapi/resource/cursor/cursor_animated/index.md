---
Title: Как работать с анимированными курсорами?
Author: Nomadic 
Date: 01.01.2007
---

Как работать с анимированными курсорами?
========================================

::: {.date}
01.01.2007
:::

Answer:

To use an animated cursor you have several options: load it from a file
(using LoadImage or LoadCursorFromFile), load it from a resource (using
LoadCursor) or even creating the cursor at runtime (using CreateCursor).

Note:

You should implement custom cursors as resources. Rather than create the
cursors at run time, use the LoadCursor, LoadCursorFromFile, or
LoadImage function to avoid device dependence, to simplify localization,
and to enable applications to share cursor designs.

  --- ------------------------------
  ·   Loading a cursor from a file
  --- ------------------------------

The easiest way to load a cursor from a file is by using
LoadCursorFromFile.

This functions returns a handle to the loaded cursor that you should
assign to your application Cursors array.

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

You can also use LoadImage instead of LoadCursorFromFile like this: 

hCur := LoadImage(0, PChar(PChar(\'path\_to\_my\_cursor\')),
IMAGE\_CURSOR, 0, 0,

LR\_DEFAULTSIZE or LR\_LOADFROMFILE);

  --- ----------------------------------
  ·   Loading a cursor from a resource
  --- ----------------------------------

Before loading a cursor from a resource it\'s necessary to create the
resource file with the cursor to be loaded.

To do this create a file myResources.rc where you\'ll put the following

#define ANICURSOR 21

myCursor ANICURSOR "path\_to\_my\_cursor"

Because Borland\'s resource compiler does not understand the ANICURSOR
resource type, so you have to use the numeric id (21).

Compile your resource file using "brcc32 myResources.rc" and include
in the unit where you\'ll be loading the cursor, using {$R
myResources.res}

Now, you just have to load the cursor from the resource instead of
loading it from a file, using:

hCur := LoadCursor(HInstance, PChar(\'myCursor\'));

Remember that HInstance contains the instance handle of the application
or library as provided by Windows. This variable it\'s very importante
because it\'s the one used with many Windows API that work with current
application resources.

  --- ------------------------------
  ·   Creating a cursor at runtime
  --- ------------------------------

Another way to use a cursor it\'s creating one at runtime. Why would you
do that?

I don\'t know, it\'s your choice. I doubt you ever will create your
cursors at runtime, anyway here it\'s way how to do it.

Define the cursor map

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
     

then create the cursor

hCur := CreateCursor(HInstance, 19, 2, 32, 32, @ANDmaskCursor, @XORmaskCursor);

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

Во первых необходимо получит handle курсора, а затем определить его в
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

Автор: Nomadic 

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
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    {1.}
     
     procedure TForm1.FormCreate(Sender: TObject);
     begin
       Screen.Cursors[crMyCursor] := LoadCursorFromFile('c:\mystuff\mycursor.ani');
       Cursor := crMyCursor;
     end;
     
     
     {*****************************************************************}
     {2.}
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
     

Взято с сайта: <https://www.swissdelphicenter.ch>
