---
Title: Извлечение иконки из EXE, DLL или ICO-файла
Date: 01.01.2007
---

Извлечение иконки из EXE, DLL или ICO-файла
===========================================

::: {.date}
01.01.2007
:::

Функция SHELLAPI ExtractIconEx:

    Обратите внимание - в примере функции обьявленны иначе, чем в модуле ShellAPI 
                 type ThIconArray = array[0..0] of hIcon; 
                 type PhIconArray = ^ThIconArray; 
     
                 function ExtractIconExA(lpszFile: PAnsiChar; 
                                         nIconIndex: Integer; 
                                         phiconLarge : PhIconArray; 
                                         phiconSmall: PhIconArray; 
                                         nIcons: UINT): UINT; stdcall; 
                   external 'shell32.dll' name 'ExtractIconExA'; 
     
                 function ExtractIconExW(lpszFile: PWideChar; 
                                         nIconIndex: Integer; 
                                         phiconLarge: PhIconArray; 
                                         phiconSmall: PhIconArray; 
                                         nIcons: UINT): UINT; stdcall; 
                   external 'shell32.dll' name 'ExtractIconExW'; 
     
                 function ExtractIconEx(lpszFile: PAnsiChar; 
                                        nIconIndex: Integer; 
                                        phiconLarge : PhIconArray; 
                                        phiconSmall: PhIconArray; 
                                        nIcons: UINT): UINT; stdcall; 
                   external 'shell32.dll' name 'ExtractIconExA'; 
     
     
                procedure TForm1.Button1Click(Sender: TObject); 
                 var 
                     NumIcons : integer; 
                     pTheLargeIcons : phIconArray; 
                     pTheSmallIcons : phIconArray; 
                     LargeIconWidth : integer; 
                     SmallIconWidth : integer; 
                     SmallIconHeight : integer; 
                     i : integer; 
                     TheIcon : TIcon; 
                     TheBitmap : TBitmap; 
                 begin 
                   NumIcons := 
                   ExtractIconEx('C:\Program Files\Borland\Delphi 3\BIN\delphi32.exe', 
                                 -1, 
                                 nil, 
                                 nil, 
                                 0); 
                   if NumIcons > 0 then begin 
                     LargeIconWidth := GetSystemMetrics(SM_CXICON); 
                     SmallIconWidth := GetSystemMetrics(SM_CXSMICON); 
                     SmallIconHeight := GetSystemMetrics(SM_CYSMICON); 
                     GetMem(pTheLargeIcons, NumIcons * sizeof(hIcon)); 
                     GetMem(pTheSmallIcons, NumIcons * sizeof(hIcon)); 
                     FillChar(pTheLargeIcons^, NumIcons * sizeof(hIcon), #0); 
                     FillChar(pTheSmallIcons^, NumIcons * sizeof(hIcon), #0); 
                    ExtractIconEx('C:\Program Files\Borland\Delphi 3\BIN\delphi32.exe', 
                                   0, 
                                   pTheLargeIcons, 
                                   pTheSmallIcons, 
                                   numIcons); 
                    {$IFOPT R+} 
                      {$DEFINE CKRANGE} 
                      {$R-} 
                    {$ENDIF} 
                     for i := 0 to (NumIcons - 1) do begin 
                       DrawIcon(Form1.Canvas.Handle, 
                                i * LargeIconWidth, 
                                0, 
                                pTheLargeIcons^[i]); 
                       TheIcon := TIcon. Create; 
                       TheBitmap := TBitmap.Create; 
                       TheIcon.Handle := pTheSmallIcons^[i]; 
                       TheBitmap.Width := TheIcon.Width; 
                       TheBitmap.Height := TheIcon.Height; 
                       TheBitmap.Canvas.Draw(0, 0, TheIcon); 
                       TheIcon.Free; 
                       Form1.Canvas.StretchDraw(Rect(i * SmallIconWidth, 
                                                     100, 
                                                     (i + 1) * SmallIconWidth, 
                                                     100 + SmallIconHeight), 
                                                TheBitmap); 
                       TheBitmap.Free; 
                     end; 
                    {$IFDEF CKRANGE} 
                      {$UNDEF CKRANGE} 
                      {$R+} 
                    {$ENDIF} 
                     FreeMem(pTheLargeIcons, NumIcons * sizeof(hIcon)); 
                     FreeMem(pTheSmallIcons, NumIcons * sizeof(hIcon)); 
                   end; 
                 end; 
     
                 end. 

------------------------------------------------------------------------

Функция ExtractIcon позволяет извлечь иконку из exe, dll и ico-файлов.
Если указанная иконка отсутствует, функция возвращает 0. Количество
иконок, содержащихся в файле, можно узнать, указав в качестве последнего
параметра --1.

    uses ShellAPI;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      ic: TIcon;
      i, count: integer;
      w: integer;
    begin
      if OpenDialog1.Execute = false then
        Exit;
      Form1.Canvas.FillRect(Form1.Canvas.ClipRect);
      count := ExtractIcon(Application.Handle,
        PChar(OpenDialog1.FileName), -1);
      ic := TIcon.Create;
      w := Form1.Width div 32;
      for i := 0 to count - 1 do
      begin
        ic.Handle := ExtractIcon(Application.Handle,
          PChar(OpenDialog1.FileName), i);
        Form1.Canvas.Draw(32 * (i mod w), 32 * (i div w), ic);
      end;
      ic.Destroy;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Извлечь основную иконку EXE-файла :

    procedure TForm1.Button1Click(Sender: TObject);
     var
       Icon: TIcon;
       FileInfo: SHFILEINFO;
     begin
       Icon := TIcon.Create;
       try
         // Get the Icon 
        SHGetFileInfo(PChar('Filename.exe'), 0, FileInfo, SizeOf(FileInfo), SHGFI_ICON);
         icon.Handle := FileInfo.hIcon;
     
         DestroyIcon(FileInfo.hIcon);
         // Save the Icon to a file: 
        icon.SaveToFile('IconFromExe.ico');
         // Set the Icon as Application Icon (temporary) 
        Application.Icon := icon;
     
       finally
         Icon.Free;
       end;
     end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Процесс получения иконок из .EXE, .DLL или .ICO файлов полностью
идентичен. Различие только в том, что в .ICO файле может храниться
только одна иконка, а в .EXE и .DLL несколько. Для получения иконок из
файлов, в модуле ShellAPI, есть функция:

    function ExtractIcon(Inst: THandle; FileName: PChar; IconIndex: Word): HIcon;

где

Inst

указатель на приложение вызвавшее функцию,

FileName

имя файла из которого необходимо получить иконку,

IconIndex

номер необходимой иконки.

Если функция возвращает значение не равное нулю, то в файле есть
следующая иконка.

В данном примере в компонент Image1 выводится иконка запущенного файла.

    uses ShellAPI;
    ...
    procedure TForm1.FormCreate(Sender: TObject);
    var
      A: array [0..78] of Char;
    begin
      {Получение имени запущенного файла}
      StrPCopy(A, ParamStr(0));
      {Вывод на экран нулевой иконки из файла}
      Image1.Picture.Icon.Handle := ExtractIcon(HInstance, A, 0);
    end;

Если вы хотите создать некий браузер по иконкам, то можете
воспользоваться компонентами с закладки Win3.1. Вынесите на форму
компонент TFileListBox; затем TDirectoryListBox, в свойстве FileList
укажите на список файлов [TFileListBox]; после этого возьмите
компонент класса TDriveComboBox, указав в его свойстве DirList на список
каталогов [TDirectoryListBox], ну, и, наконец, ставьте
TFilterComboBox, который позволит в списке файлов отображать только те
файлы, которые соответствуют маске, указанной в свойстве Filter. Здесь в
качестве значения укажите следующее:
ico\|*.ico\|dll\|*.dll\|exe\|*.exe\|all\|*.ico; *.dll; *.exe ..а в
свойстве FileList задайте список файлов [TFileListBox]. В обработчике
OnClick компонента TFileListBox напишите такой код:

    var
      A: array [0..78] of Char;
    begin
      {Получение имени файла, указанного в списке файлов}
      StrPCopy(A, FileListBox1.FileName);
      {Вывод на экран нулевой иконки из файла}
      Image1.Picture.Icon.Handle := ExtractIcon(HInstance, A, 0);

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
