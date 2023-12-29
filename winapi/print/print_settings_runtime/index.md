---
Title: Изменение свойств печати во время её выполнения
Date: 01.01.2007
---

Изменение свойств печати во время её выполнения
===============================================

::: {.date}
01.01.2007
:::

Как разрешить изменения свойств принтера (например, лоток с бумагой,
ориентация и др.) между страницами печати одного документа в шести
шагах.

(В совете также приведен пример изменения поддона с бумагой...)

## ШАГИ

1. Создайте копию модуля Printers.pas и переименуйте его в NewPrint.pas.

**НЕ делайте изменения в самом модуле Printers.pas!
Если вы сделаете это, то получите во время компиляции приложения ошибку
\"Unable to find printers.pas\" (не могу найти printer.pas).
(Я уже получал её, поэтому и упоминаю об этом здесь...)**

2. Переместите модуль NewPrint.pas в директорию Lib.

(Используйте "C:\\Program Files\\Borland\\Delphi Х\\Lib" )

3. Измените ИМЯ МОДУЛЯ на NewPrint.pas

с:

   unit Printers

на:

   unit NewPrint

4. Добавьте декларацию следующего PUBLIC метода класса TPrinter в секции
Interface модуля NewPrint.pas:

    procedure NewPageDC(DM: PDevMode);


5. Добавьте следующую процедуру в секцию реализации NewPrint.pas:


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

Вместо добавления \"Printers\" в секцию USES вашего приложения (список
используемых модулей), добавьте \"NewPrint\".

6. Теперь вдобавок к старым методам (таким как BeginDoc, EndDoc, NewPage и
др.), у вас появилась возможность изменения свойств принтера \"на
лету\", т.е. между страницами при печати одного и того же документа.
(Пример приведен ниже.)

Вместо вызова:

    Printer.NewPage;

напишите:

    Printer.NewPageDC(DevMode);

Вот небольшой пример:

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

**Примечание от автора:**

Я использовал это во многих своих программах, поэтому я уверен в
работоспособности кода.

Данный кода был создан в Delphi Client/Server 2.01 под WinNT 4.0, но
впоследствии был проверен на других версиях Delphi, а также под Windows95.

Правда я еще не поробовал его под Delphi 4... Если вы имеете любые
комментарии или улучшения, не постесняйтесь отправить их мне...

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
