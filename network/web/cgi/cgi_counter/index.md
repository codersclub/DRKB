---
Title: Создание CGI счетчика в Delphi 5
Date: 01.01.2007
---


Создание CGI счетчика в Delphi 5
================================

::: {.date}
01.01.2007
:::

Создание CGI счётчика в Delphi 5

(Перевод одноимённой статьи с сайта
http://homepages.borland.com/aohlsson/Articles/CounterCGI.html)

Если Вы программируете в Delphi и, хотели бы, чтобы Ваш любимый
компилятор поучавствовал в создании Вашей веб-странички, то можно начать
с маленькой, но довольно важной части веб-проекта - счётчика. Обычно,
счётчик выглядит как кнопка на странице. В данном случае это JPEG
картинка, генерируемая на лету.

Те, кто желает сразу приступить к компиляции, могут скачать исходник и,
в случае возникновения каких либо вопросов, вернуться к данной статье.

 

Вызывается счётчик тэгом IMG примерно так:

\<img
src=\"http://ww5.borland.com/scripts/CounterCGI.exe?FileName=Article\"\>

CGI скрипт так же может получать определённый набор параметров:

    Txt              e.g. \"You are visitor %d today, and %d ever.\"

    FontName         e.g. \"Courier\"

    FontColor        e.g. \"clGreen\"  or \"$404040\"

    BackgroundColor  e.g. \"clYellow\" or \"$808080\"

А вот так выглядит вызов скрипта с несколькими параметрами:

http://ww5.borland.com/scripts/CounterCGI.exe?FileName=Article&BackgroundColor=$808080&FontColor=$404040&FontName=Courier

Итак, давайте разбираться с кодом.

Начать создавать новое CGI приложение следует с выбора File \| New \|
Web Server Application \| CGI stand-alone executable. После этого Вы
получите чистый Web модуль. Добавьте новый TWebActionItem в подсвеченном
свойстве действий (Actions) в TWebModule, нажав на Add Item. Затем
двойным щелчком на событие OnAction создайте обработчик действия.

Изображение JPEG, получается как снимок изображения с TPanel, с TMemo
внитри него. Таким способом легче придать 3D вид счётчику. Для начала
нам необходимо добавить следующую строку в раздел implementation:

    implementation

    uses

      ExtCtrls, StdCtrls, Controls, Forms, Graphics, JPEG;

Теперь, мы определим некоторые основные процедуры, которые будут
использоваться в коде. GetPaths будет обеспечивать нас двумя жизненно
важными путями. Первый путь будет указывать где хранится сам скрипт по
отношению к корневой директории web сервера (т.е. относительный путь).
Скорее всего это будет \"scripts\" или \"cgi-bin\" в зависимости от
того, куда Вы его положите. Второй - это локальный путь в Windows. Он
может выглядеть как \"C:\\InetPub\". Для нас важны оба пути, чтобы
обеспечить переносимость CGI скрипта из директории в директорию и с
одного сервера на другой.

         procedure GetPaths(Request: TWebRequest; var ScriptPath, LocalPath : String);
         var
           ScriptFileName : String;
         begin
           ScriptPath := Request.ScriptName;
           ScriptFileName := ExtractFileName(ParamStr(0));
           // Убираем EXE/DLL имя, чтобы получить путь
           Delete(ScriptPath,Pos(ScriptFileName,ScriptPath)-1,Length(ScriptFileName)+1);
           // Убираем главную косую
           Delete(ScriptPath,1,1);
     
           LocalPath := ExtractFilePath(ParamStr(0));
           // Удаление ScriptPath даёт нам корневой путь
           Delete(LocalPath,Pos(ScriptPath,LocalPath)-1,Length(ScriptPath)+1);
         end;

Процедура SetVariable будет использоваться для инициализации нужных нам
переменных.

      procedure SetVariable(var S : String; const Value, Default : String);
         begin
           S := Value;
           if S = '' then
             S := Default;
         end;

Вся суть CGI скрипта заключается в событие OnAction. Давайте рассмотрим
его по шагам.

    procedure TWebModule1.WebModule1WebActionItem1Action(Sender:
TObject;

      Request: TWebRequest; Response: TWebResponse; var Handled:
Boolean);

Сперва объявим некоторые локальные переменные.

         var
           ScriptPath,
           LocalPath,
           FileName,
           Txt, FontColor,
           BackgroundColor,
           FontName,
           FontSize        : String;
           Today, LastEver,
           Ever, LastToday : Integer;
           LastDate        : TDate;
           MS              : TMemoryStream;
           Panel           : TPanel;
           Memo            : TMemo;
           Bitmap          : TBitmap;
           Form            : TForm;
           fp              : TextFile;

Теперь вызовем GetPaths, чтобы выяснить путь к скрипту, а так же
локальный путь. В данном примере мы будем помещать наши счётчики в
директорию \"counters\". Физический путь будет выглядеть примерно так
\"C:\\InetPub\\counters\".

         begin
           GetPaths(Request,ScriptPath,LocalPath);
           LocalPath := LocalPath+'counters\';

Затем, мы получаем все параметры, переданные вместе с вызовом скрипта.
Параметры поступают к нам через свойство Request.QueryFields. Обратите
внимание, что если какой-то параметр не был передан, то SetVariable
устанавливает его по умолчанию.

           with Request.QueryFields do begin
             FileName := LocalPath+Values['FileName']+'.txt';
             SetVariable(Txt,Values['Txt'],'You are visitor %d today, and %d ever.');
             SetVariable(FontName,Values['FontName'],'Arial');
             SetVariable(FontSize,Values['FontSize'],'10');
             SetVariable(FontColor,Values['FontColor'],'clWhite');
             SetVariable(BackgroundColor,Values['BackgroundColor'],'clBlack');
           end;

Теперь мы должны быть уверены, что присутствует файл для данного
счётчика. Если его нет, то просто создаём его.

           try
             // Write a new empty counter file if it doesn't exist
             if not FileExists(FileName) then begin
               AssignFile(fp,FileName);
               Rewrite(fp);
               WriteLn(fp,0);
               WriteLn(fp,Date);
               WriteLn(fp,0);
               CloseFile(fp);
             end;

Итак, файл существует. Естевственно, если мы создали его, что счётчик
будет равен 0, иначе будем считывать старые значения, и зменять их, если
необходимо. Обратите внимание, на то, как мы отслеживаем общее число
посещение и посещений за день.

             // Читаем старые значения счётчика
             AssignFile(fp,FileName);
             Reset(fp);
             ReadLn(fp,LastEver);
             Ever := LastEver+1;
             ReadLn(fp,LastDate);
             ReadLn(fp,LastToday);
             if Date = LastDate then
               Today := LastToday+1
             else
               Today := 1;
             CloseFile(fp);

И в заключении, надо записать новые значения в файл, содержащий данные
счётчика.

             // Записываем новые значения счётчика
             AssignFile(fp,FileName);
             Rewrite(fp);
             WriteLn(fp,Ever);
             WriteLn(fp,Date);
             WriteLn(fp,Today);
             CloseFile(fp);

Теперь приступим к созднию того, что в конечном итоге будет называться
JPEG. Для начала сделаем невидимым TForm которая содержит TPanel и
TMemo. Так же устанавливаем FontName и FontSize.

             Form := TForm.Create(nil);
             with Form.Font do begin
               Name := FontName;
               Size := StrToInt(FontSize);
             end;

Удостоверимся в том, что текст, который мы помещаем в memo контрол,
содержит значения счётчика, считанные из файла.

             Txt := Format(Txt,[Today,Ever]);

Далее мы создаём панель. Ширина и высота будут определяться шириной
текста, который мы помещаем в неё. Так же устанавливаем скашивание для
3D эффекта.

             Panel := TPanel.Create(nil);
             with Panel do begin
               BevelInner := bvRaised;
               BevelOuter := bvLowered;
               Parent := Form;
               Width := Form.Canvas.TextWidth(Txt)+9;
               Height := Form.Canvas.TextHeight(Txt)+9;
             end;

Помещаем memo в панель, и устанавливаем её ширину и высоту, а так же
цвет, который указан в BackgroundColor.

             Memo := TMemo.Create(nil);
             with Memo do begin
               Top := 2;
               Left := 2;
               Width := Panel.Width-5;
               Height := Panel.Height-5;
               Alignment := taCenter;
               Color := StringToColor(BackgroundColor);
               BorderStyle := bsNone;
               Parent := Panel;
             end;

Теперь необходимо сделать изображение эелемента управления, который мы
создали. Для этого создаём TBitmap и закрашеваем его панелью. За одно
рисуем текст на битмапе.

             Bitmap := TBitmap.Create;
             with Bitmap do begin
               Width := Panel.Width-1;
               Height := Panel.Height-1;
               Canvas.Lock;
               Panel.PaintTo(Canvas.Handle,0,0);
               Canvas.Unlock;
               Canvas.Brush.Style := bsClear;
               with Canvas.Font do begin
                 Name := FontName;
                 Size := StrToInt(FontSize);
                 Color := StringToColor(FontColor);
               end;
               Canvas.TextOut(4,3,Txt);
             end;

Затем преобразовываем bitmap в JPEG. JPEG будет записан в memory stream.
Этот поток будет связан с браузером и передаваться посетителю странички
в виде картинки.

             with Response do begin
               MS := TMemoryStream.Create;
               with TJPEGImage.Create do begin
                 CompressionQuality := 75;
                 Assign(Bitmap);
                 SaveToStream(MS);
                 Free;
               end;
               ContentType := 'image/jpeg';
               MS.Position := 0;
               SendResponse;
               SendStream(MS);
             end;

Освобождаем ресурсы.

             Panel.Free;
             Bitmap.Free;
             Form.Free;

На всякий случай обрабатываем исключительные ситуации.

           except
             on E: Exception do
               Response.Content := E.Message;
           end;
           Handled := True;
         end;

Вот собственно и всё. Наслаждайтесь счётчиком, сделанным в Delphi 5 :)
