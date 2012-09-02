<h1>Изменение свойств печати во время её выполнения</h1>
<div class="date">01.01.2007</div>


<p>Как разрешить изменения свойств принтера (например, лоток с бумагой, ориентация и др.) между страницами печати одного документа в шести шагах.</p>

<p>(В совете также приведен пример изменения поддона с бумагой...)</p>

<p>*** ШАГИ ***</p>
<p>Создайте копию модуля Printers.pas и переименуйте его в NewPrint.pas.</p>

<p>***НЕ делайте изменения в самом модуле Printers.pas, если вы сделаете это, то получите во время компиляции приложения ошибку "Unable to find printers.pas" (не могу найти printer.pas). (Я уже получае ее, поэтому и упоминаю об этом здесь...)***</p>

<p>Переместите модуль NewPrint.pas в директорию Lib.</p>

<p>(Используйте "C:\Program Files\Borland\Delphi Х\Lib" )</p>

<p>Измените ИМЯ МОДУЛЯ на NewPrint.pas</p>

<p>с:</p>
<p> &nbsp;&nbsp; unit Printers </p>

<p>на:</p>
<p> &nbsp;&nbsp; unit NewPrint </p>

<p>Добавьте декларацию следующего PUBLIC метода класса TPrinter в секции Interface модуля NewPrint.pas:</p>

<p> &nbsp;&nbsp; procedure NewPageDC(DM: PDevMode); </p>

<p>Добавьте следующую процедуру в секцию реализации NewPrint.pas:</p>
<pre>
procedure TPrinter.NewPageDC(DM: PDevMode);
begin
  CheckPrinting(True);
  EndPage(DC);
{Проверяем наличие новых установок для принтера}
  if Assigned(DM) then
    ResetDC(DC, DM^);
  StartPage(DC);
  Inc(FPageNumber);
  Canvas.Refresh;
end;
</pre>


<p>Вместо добавления "Printers" в секцию USES вашего приложения (список используемых модулей), добавьте "NewPrint".</p>

<p>Теперь вдобавок к старым методам (таким как BeginDoc, EndDoc, NewPage и др.), у вас появилась возможность изменения свойств принтера "на лету", т.е. между страницами при печати одного и того же документа. (Пример приведен ниже.)</p>
<p>Вместо вызова:</p>

<p> &nbsp;&nbsp; Printer.NewPage; </p>

<p>напишите: </p>

<p> &nbsp;&nbsp; Printer.NewPageDC(DevMode); </p>

<p>Вот небольшой пример:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  ADevice, ADriver, APort: array[0..255] of char;
  ADeviceMode: THandle;
  DevMode: PDevMode;
begin
  with Printer do
    begin
      GetPrinter(ADevice, ADriver, APort, ADeviceMode);
      SetPrinter(ADevice, ADriver, APort, 0);
      GetPrinter(ADevice, ADriver, APort, ADeviceMode);
      DevMode := GlobalLock(ADeviceMode);
      if not Assigned(DevMode) then
        ShowMessage('Не могу установить принтер.')
      else
        begin
          with DevMode^ do
            begin
{Применяем здесь любые настройки, необходимые для изменения установок печати}
              dmDefaultSource := DMBIN_UPPER;
{этот код приведен в "Windows.pas"}
            end;
          GlobalUnlock(ADeviceMode);
          SetPrinter(ADevice, ADriver, APort, ADeviceMode);
        end;
    end;
  Printer.BeginDoc;
  Printer.Canvas.TextOut(50, 50, 'Эта страница печатается из ВЕРХНЕГО ЛОТКА.');
  with DevMode^ do
    begin
{Применяем здесь любые настройки, необходимые для изменения установок печати}
      dmDefaultSource := DMBIN_LOWER;
{этот код приведен в "Windows.pas"}
    end;
  Printer.NewPageDC(DevMode);
  Printer.Canvas.TextOut(50, 50, 'Эта страница печатается из НИЖНЕГО ЛОТКА.');
  Printer.EndDoc;
end;
</pre>


<p class="note">Примечание от автора:</p>

<p>Я использовал это во многих своих программах, поэтому я уверен в работоспособности кода.</p>

<p>Данный кода был создан в Delphi Client/Server 2.01 под WinNT 4.0, но впоследствии был</p>
<p>проверен на других версиях Delphi, а также под Windows95.</p>
<p>Правда я еще не поробовал его под Delphi 4... Если вы имеете любые комментарии или улучшения,</p>
<p>не постесняйтесь отправить их мне...</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

