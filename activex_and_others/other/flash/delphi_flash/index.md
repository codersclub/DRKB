---
Title: Delphi и Flash
Author: Михаил Христосенко.
Date: 01.01.2007
---


Delphi и Flash
==============

::: {.date}
01.01.2007
:::

Delphi и Flash. Совмещение несовместимого!

Разве возможно совместить Флэш-ролики и Дельфи-приложения. Раньше я
думал что НЕТ. Но теперь я знаю не только, что это возможно, но и знаю
как это делается!!! И сейчас я вам расскажу об этом. Во-первых хочется
отметить преимущества использования флэш-роликов в ваших программах.
Если вы сумеете гармонично вписать небольшой флэш-ролик в вашу
программу, то несомненно внешний вид программы будет намного
привлекательнее (главное не переборщить, увлекаясь дизайном, не надо
забывать о том что программа должна быть удобна и проста в
использовании! ).

Итак, как же совместить Флэш и Дельфи? (Надеюсь, что у вас Флэш
установлен:))

Запустите Дельфи и выберите пункт меню Component-\>Import ActiveX
Control... Перед вами откроется диалоговое окно с заголовком Import
ActiveX Control. В разделе Registered Controls выберите Shockwave Flash.
В разделе Pallete Page... Выберите страницу в палитре компонентов, на
которой будет располагаться установленный компонент (по умолчанию это
ActiveX). В разделе Unit Dir Name... путь к папке куда будет установлен
компонент.

Нажмите на кнопку Install. Перед вами появится окно, в котором вам нужно
будет выбрать в какой пакет будет установлен компонент (вы можете
установить как в уже существующий, так и в новый пакет). Затем перед
вами появится окно редактирования выбранного пакета и Дельфи вас
спросит: \"...Package will be rebuilt. Continue?\". Ответьте Yes. Все
готово теперь можно использовать флэш в ваших приложениях!!!

Теперь, чтобы показать вам как пользоваться этим компонентом, попробуем
вместе сделать программу для просмотра *.SWF файлов. Для этого нам
понадобятся следующие компоненты: TShockwaveFlash (для удобства назовите
его просто Flash1), TTrackBar, TTimer, TOpendialog и три кнопки TButton
(\"открыть\", \"старт\" и \"стоп\").

Для начала установим необходимые свойства OpenDialog\'a

Свойство Filter может быть таким: Флэш-ролики\|*.swf

Свойство DefaultExt должно быть: *.swf

Для Timer\'a нужно установить свойство Interval равным 1.

Для TShockwaveFlash:

Name сделайте равным Flash1

Свойство Playing установите в false

Свойство BGColor, установите как вам хочется (цвет фона)

Теперь напишем обработчик события OnClick для кнопки, которая вызывать
OpenDialog:

if open1.Execute then begin

flash1.Movie:=open1.FileName;

trackbar1.Max:=flash1.TotalFrames; {это делается для того, чтобы потом
можно было перемещаю ползунок посмотреть каждый кадр ролика}

В обработчик события OnClick для второй кнопки (\"Старт\") напишем:

flash1.Play;

Ну тут вообще все просто! Почти таким же образом это будет выглядеть для
третьей кнопки (\"Стоп\"):

flash1.Stop;

Теперь сделаем, чтобы при перемещении ползунка Trackbar\'a мы могли
посмотреть каждый кадр (событие OnChange):

if Flash1.IsPlaying=true then Flash1.Stop; {если ролик проигрывается, то
надо его остановить}

flash1.GotoFrame(trackbar1.position); {открываем кадр номер которого
соответствует позиции ползунка}

Ну и наконец осталось сделать чтобы при проигрывании ролика ползунок
перемещался, указывая сколько осталось и сколько прошло. Для этого то мы
и используем Timer. В обработчик события OnTimer,напишем:

trackbar1.Position:=flash1.CurrentFrame;

Приведу полный код приложения:

    unit flash;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ComCtrls, StdCtrls, OleCtrls, ShockwaveFlashObjects_TLB, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        Flash1: TShockwaveFlash;
        Button1: TButton;
        TrackBar1: TTrackBar;
        Open1: TOpenDialog;
        Button2: TButton;
        Button3: TButton;
        Timer1: TTimer;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure Button3Click(Sender: TObject);
        procedure TrackBar1Change(Sender: TObject);
        procedure Timer1Timer(Sender: TObject);
      private
    { Private declarations }
      public
    { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if open1.Execute then
        begin
          flash1.Movie := open1.FileName;
          trackbar1.Max := flash1.TotalFrames;
        end;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      flash1.Play;
    end;
     
    procedure TForm1.TrackBar1Change(Sender: TObject);
    begin
      if Flash1.IsPlaying = true then Flash1.Stop;
      flash1.GotoFrame(trackbar1.position);
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      flash1.Stop;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      trackbar1.Position := flash1.CurrentFrame;
    end;
     
    end.

Ну вот и все. Как оказалось ничего сложного.

Дополнительная информация

Автор: Михаил Христосенко.

Если у вас возникнут какие-нибудь вопросы, предложения и пожелания, а
также ваши отзывы шлите по почте: kikoz\@kemtel.ru

Заходите на мой сайт http://MihanDelphi.narod.ru там вы найдете
множество программ (моих и не только), компонентов, статей и еще
множество полезностей для Дельфера.

Взято с сайта [www.emanual.ru](https://www.emanual.ru)
