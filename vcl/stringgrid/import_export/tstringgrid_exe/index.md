---
Title: Экспорт TStringGrid в исполняемый файл *.exe
Author: Kostas
Date: 01.01.2007
---


Экспорт TStringGrid в исполняемый файл *.exe
=============================================

::: {.date}
01.01.2007
:::

Экспорт StringGrid в исполняемый файл *.EXE

Как-то раз мне понадобилось из моей программы извлекать все содержимое
StringGrid\'a в exe-файл. В данном случае можно конечно писать свой
собственный компилятор, но, согласитесь, это лишнее. Гораздо проще
заранее написать exe-файл и поместить его в ресурсы нашей программы. А
потом извлекать его оттуда, и записывать в его ресурсы содержимое
StringGrid\'a. Заманчиво звучит, правда? Тогда перейдем к реализации.

1. Создание exe-файла, в который поместим в конце содержимое
StringGrid\'a.

Так как данная статья посвящена языку Делфи, то и писать этот exe-файл я
рекомендую на Делфи. Запускаем Делфи, создаем новый проект, и на форму
кидаем StringGrid. Это обязательный набор, но вы можете добавить все что
угодно, все, что вы хотели бы видеть, после того как сделаете экспорт из
StringGrid\'a в исполняемый файл.
Ниже представлен код процедуры загрузки содержимого из ресурсов в
StringGrid:

 

    procedure LoadStringGrid(StrGrid: TStringGrid;FName: TStream);
    var
    LoadList: TStringList;
    i, j, ListCurentLine: integer;
    begin
    LoadList := TStringList.Create;
    try
    LoadList.LoadFromStream(FName);
     
    If TryStrToInt(LoadList.Strings[0]) then
     StrGrid.RowCount := StrToInt(LoadList.Strings[0]);
    If TryStrToInt(LoadList.Strings[1]) then
     StrGrid.ColCount := StrToInt(LoadList.Strings[1]);
    If TryStrToInt(LoadList.Strings[2]) then
     StrGrid.FixedRows := StrToInt(LoadList.Strings[2]);
    If TryStrToInt(LoadList.Strings[3]) then
     StrGrid.FixedCols := StrToInt(LoadList.Strings[3]);
     
    ListCurentLine := 4;
    for j := 0 to StrGrid.RowCount-1 do
     for i := 0 to StrGrid.ColCount-1 do
      begin
       StrGrid.Cells[i, j] := LoadList.Strings[ListCurentLine];
       Inc(ListCurentLine);
      end;
     
    finally
    LoadList.Free;
    end;
    end;



Теперь в обработчике события формы OnCreate напишите следующий код:

    procedure TForm1.FormCreate(Sender: TObject);
    var
      RS : TResourceStream;
    begin
    RS := TResourceStream.Create(HInstance, 'EXEEXPORT', 'MYEXE');
    try
    LoadStringGrid(StringGrid1,RS);
    finally
    RS.Free;
    end;
    end;


Теперь постройте ваш exe-файл. Перейдем к следующему вопросу.

2. Помещение exe-файла в ресурсы вашей программы.

Скопируйте только что созданный exe-файл на диск C: (можно на любом
другом, это для примера) и назовите его Exe.exe. Там же создайте файл
123.rc. Откройте его в блокноте и напишите туда следующее: Data Export
C:\\Exe.exe. Теперь запустите программу brcc32.exe из каталога
Delphi\\Bin, передав ей в качестве параметра полный путь к файлу 123.rc.
В нашем случае: Delphi\\Bin\\brcc32.exe C:\\123.rc. После этого вы
получите скомпилированный ресурс 123.res. Скопируйте его в директорию
проекта вашей программы.

Теперь откройте в Делфи проект с вашей программой и откройте окно с
кодом. После слова implementation напишите:

    {Грузим ресурс} 
    {$R 123.res}



Все, exe-файл теперь будет в ресурсах вашей программы.

3. Извлечение exe-файла из вашей программы.


Ну, с этим проще всего, вот процедура для извлечения файла из ресурсов:

    procedure ExportExeFromRes(ResName: string; S: string);
    var 
      ResHandle: THandle; 
      MemHandle: THandle; 
      MemStream: TMemoryStream; 
      ResPtr: PByte;
      ResSize: Longint; 
    begin
      ResHandle := FindResource(hInstance, PChar(ResName), 'Export');
      MemHandle := LoadResource(hInstance, ResHandle); 
      ResPtr := LockResource(MemHandle); 
      MemStream := TMemoryStream.Create;
      ResSize := SizeOfResource(hInstance, ResHandle);
      MemStream.SetSize(ResSize);
      MemStream.Write(ResPtr^, ResSize); 
      FreeResource(MemHandle);
      MemStream.Seek(0, 0); 
      //Сохраняем в файл
      MemStream.SaveToFile(S);
      MemStream.Free;
    end;



Пример вызова:

    ExportExeFromRes('Data', путь куда извлекать);



4. Помещение в ресурсы извлеченного файла содержимого StringGrid\'a.

Вот это было для меня самым сложным. Но мне помог один человек с ником
Alex-Co, который ко всему прочему является автором отличного модуля
AcWorkRes.pas. Этот модуль нам понадобится, его можно скачать тут и
почитать про него тут.
Итак, установите этот модуль. Для этого откройте его и нажмите в Делфи
Component\\Install Component. После этого в появляющихся окнах нажимайте
ОК, Compile и возможно Install.
Затем пропишите в разделе uses этот модуль.

Ниже представлен код процедуры, которая сохраняет содержимое
StringGrid\'a в ресурсы exe-файла:

     
    procedure SaveStringGridToFile(StrGrid: TStringGrid; FName: string);
    var
    SaveList: TStringList;
    i, j: integer;
    Handle: THandle;
    s: String;
    begin
    SaveList := TStringList.Create;
    try
    SaveList.Add(IntToStr(StrGrid.RowCount));
    SaveList.Add(IntToStr(StrGrid.ColCount));
    SaveList.Add(IntToStr(StrGrid.FixedRows));
    SaveList.Add(IntToStr(StrGrid.FixedCols));
     
    for j := 0 to StrGrid.RowCount-1 do
    for i := 0 to StrGrid.ColCount-1 do
     begin
      SaveList.Add(StrGrid.Cells[i, j]);
     end;
     
    notLang:= True;
    try
      s:=SaveList.Text;
      Handle := BeginUpdateResourceW(StringToPWide(FName),false);
      UpdateResourceW(Handle,'MYEXE','EXEEXPORT',LANG_NEUTRAL,@(s[1]),Length(s));
      EndUpdateResourceW(Handle, false);
    finally
      notLang:= False;
    end;
    finally
    SaveList.Free;
    end;
    end;



Пример вызова:

    SaveStringGridToFile(StringGrid1, путь к файлу exe);



5. Поздравляю вас!


Ну, вот и все! Все готово, теперь для того, чтобы извлечь exe-файл из
вашей программы и поместить в его ресурсы содержимое StringGrid\'a,
выполните следующий код:

    ExportExeFromRes('Data', путь);
    SaveStringGridToFile(StringGrid1, тот же самый путь);



Теперь вы научились делать экспорт из StringGrid\'a в исполняемый файл.
Как видите, ничего сложного, и не обязательно писать свой компилятор.
Также хочу отметить, что, немного преобразовав данный код, можно делать
экспорт из чего угодно!


Автор: Kostas

Взято из <https://forum.sources.ru>




 
