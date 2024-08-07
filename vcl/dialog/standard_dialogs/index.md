---
Title: TOpenDialog, TSaveDialog, TOpenPictureDialog и TSavePictureDialog
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


TOpenDialog, TSaveDialog, TOpenPictureDialog и TSavePictureDialog
=================================================================

_Перевод одноимённой статьи с сайта delphi.about.com_

**Стандарные диалоговые окошки**

Практически любое приложение Windows использует стандартные диалоги,
встроенные в операционную систему, для открытия и сохранения файлов,
поиска текста, печати, выбора шрифта или установки цвета.

В этой статье мы рассмотрим основные свойства и методы этих диалогов и,
особенно, сфокусируем внимание на диалогах Open и Save.

Стандартные диалоговые окошки можно найти на панели компонентов в
закладке Dialogs. Для того, чтобы начать использовать определённое
диалоговое окошко, его достаточно поместить на форму. Компоненты
стандартных диалогов являются невидимыми, поэтому Вы не сможете изменить
дизайн такого диалога во время разработки приложения.

**TOpenDialog и TSaveDialog**

Диалоговые окошки File Open и File Save имеют несколько общих свойств.
File Open в основном используется для выбора и открытия файлов, в то
время как диалог File Save (так же используется как диалоговое окошко
Save As) используется для получения от пользователя имени файла, чтобы
сохранить файл. Далее мы рассмотрим некоторые важные свойства
TOpenDialog и TSaveDialog:

Свойство Options предназначено для задания конечного вида окна.
Например, при помощи следующего кода:

    with OpenDialog1 do
      Options := Options + [ofAllowMultiSelect, ofFileMustExist];

мы позволим пользователю выбирать несколько файлов, а так же заставим
генерироваться сообщение об ошибке, если пользователь выберет
несуществующий файл.

Свойство InitialDir используется для указания директории, которая будет
показана при создании диалога. Следующий код установит начальную
директорию, из которой было запущено приложение:

    SaveDialog1.InitialDir := ExtractFilePath(Application.ExeName);

Свойство Filter содержит список типов файлов, которые сможет выбирать
пользователь. Когда пользователь выберет тип файлов, то в диалоговом
окне будут отображаться только файлы данного расширения. Фильтр можно
легко установить на стадии создания приложения при помощи диалога
редактора фильтра (Filter Editor): 

Так же фильтр можно задать программно. Строка фильтра должна содержать
описание и расширение для данного типа файлов, разделённые вертикальной
чертой:

    OpenDialog1.Filter := 'Text files (*.txt)|*.txt|All files (*.*)|*.*';

Свойство FileName. Когда пользователь нажмёт на диалоге кнопку OK, то
это свойство будет содержать полный путь и имя выбранного файла.

**Вызов диалогового окошка**

Для создания и отображения стандартного диалога необходимо выполнить
метод Execute для нужного диалога. За исключением диалогов TFindDialog и
TReplaceDialog, все остальные диалоги отображаются модально.

Все стандартные диалоговые окошки позволяют определить нажал ли
пользователь кнопку "Отмена" (Cancel) (или нажал ESC). Если метод
Execute вернул True значит пользователь нажал OK или сделал двойной
щелчёк по файлу либо нажал Enter на клавиатуре, иначе, если  была нажата
кнопка Cancel, клавиша Esc или Alt-F4, будет возвращено значение False.

    if OpenDialog1.Execute then
      ShowMessage(OpenDialog1.FileName);

Этот код показывает диалог File Open и, если пользователь нажал
"Открыть" (Open), то будет показано имя выбранного файла.

**Использование только кода**

Чтобы работать диалогом Open (или любым другим) не помещая при этом на
форму компонент OpenDialog, можно воспользоваться следующим кодом:

    procedure TForm1.btnFromCodeClick(Sender: TObject);
    var OpenDlg : TOpenDialog; 
    begin OpenDlg := TOpenDialog.Create(Self); 
     {здесь устанавливаем опции...}
     if OpenDlg.Execute then begin 
      {здесь что-нибудь делаем} 
     end; 
     OpenDlg.Free; 
    end;

Обратите внимание, что перед вызовом Execute, можно установить различные
свойства компонента OpenDialog.

**TOpenPictureDialog и TSavePictureDialog**

Эти два диалога есть ничто иное как обычные File Open и File Save с
дополнительной возможностью предварительного просмотра выбранной
картинки.

**Мой Блокнот**

А теперь предлагаю применить теорию на практике. Создадим простейший
блокнот, и посмотрим как работают диалоговые окошки Open и Save:

Для создания блокнота проделаем следующее:

- Запустите Delphi и выберите в меню File-New Application.
- Поместите на форму Memo, OpenDialog, SaveDialog и две кнопки.
- Переименуйте Button1 в btnOpen, а Button2 в btnSave.

Код

1. Поместите в событие формы FormCreate следующий код:

    ```delphi
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     with OpenDialog1 do begin
      Options:=Options+[ofPathMustExist,ofFileMustExist];
      InitialDir:=ExtractFilePath(Application.ExeName);
      Filter:='Text files (*.txt)|*.txt';
     end;
     with SaveDialog1 do begin
      InitialDir:=ExtractFilePath(Application.ExeName);
      Filter:='Text files (*.txt)|*.txt';
     end;
     Memo1.ScrollBars := ssBoth;
    end;
    ```

    Этот код устанавливает некоторые свойства диалога Open как было описано
    в начале статьи.

2. Добавьте следующий код в событие Onclick для кнопок btnOpen и btnSave:

    ```delphi
    procedure TForm1.btnOpenClick(Sender: TObject);
    begin
     if OpenDialog1.Execute then begin
      Form1.Caption := OpenDialog1.FileName;
      Memo1.Lines.LoadFromFile
        (OpenDialog1.FileName);
      Memo1.SelStart := 0;
     end;
    end;
     
    procedure TForm1.btnSaveClick(Sender: TObject);
    begin
     SaveDialog1.FileName := Form1.Caption;
     if SaveDialog1.Execute then begin
       Memo1.Lines.SaveToFile
         (SaveDialog1.FileName + '.txt');
       Form1.Caption:=SaveDialog1.FileName;
     end;
    end;
    ```

Теперь можно смело запускать проект

