---
Title: Работа с Microsoft Speech API в Delphi
Author: Альберт Мамедов, https://www.delphimaster.ru
Date: 01.01.2007
---


Работа с Microsoft Speech API в Delphi
======================================

В ходе создания программного обеспечения возникает желание дополнить
возможности создаваемого приложения голосовым интерфейсом.

Если возможности распознания голоса ещё далеки от совершенства и
простому программисту не по силам, то заставить ваше приложение весьма
сносно заговорить может любой программист.

Об этом позаботились специалисты Microsoft выпустив на рынок бесплатный
ActiveX компонент TextToSpeech входящий в стандартную комплектацию WinMe
и Win 2x.

Если у Вас этого компонента нет Вам необходимо скачать и установить
Microsoft Speech API 4.0 825 Кб и Lernout &Hauspie Text-To-Speech 2.9 Мб
(русский мужской и женский голос.)

Применение этого компонента позволяет значительно расширить
функциональные возможности интерфейса создаваемой программы. Приятно
когда программа говорит «человеческим голосом». Как пример моя программа
общения по сети. Исходный текст прилагаю..

Рассмотрим пример применения Microsoft Speech API.

Используем позднее связывание освобождающее программиста от написания
лишнего кода и облегчающего в дальнейшем модификацию приложения.

Для размещения ActiveX компонентов будем использовать универсальный
класс-контейнер TAxControl, подробно описанный в книге «Delphi для
профессионалов» авторы Александровский А.Д., Шубин В.В.

    unit axControl;
    { Класс-контейнер для ActiveX (компонента управления). }
    interface
    uses
    Windows, Messages, Classes, Controls,
    ActiveX, OleCtrls,StdCtrls; //
    ///********************************************************************
    type
    TAxControl = class(TOleControl)//
    private
    CControlData : TControlData2; // Информация об ActiveX.
    protected
    procedure InitControlData; override;
    public
    property CData : TControlData2 read CControlData;
    constructor Create (AOwn : TComponent;AGUID : TGUID);
    end;
    implementation
    //////////////////////////////////////////////////////////////////////////////
    constructor TAxControl. Create (AOwn : TComponent ;AGUID : TGUID);
    begin
    FillChar(CControlData,sizeof(CControlData),0); // Обнуляете поле с информацией об Active
    CControlData.ClassID :=AGUID; // Указываете QUID компонента,который будет создаваться.
    inherited Create (AOwn); // Вызываете конструктор предка.
    ControlStyle := ControlStyle + [csClickEvents]; // Стиль отображения
    end ;
    ///////////////////////////////////////////////////////////////////////////////////
    procedure TAxControl. InitControlData;
    begin
    ControlData := @CControlData; // Указываете адрес, где находится информация об ActiveX.
    end;
     
    //////////////////////////////////////////////////////////////////////////////////////
    end.

 

Размещаем TextToSpeech на Delphi компонент Panel и устанавливаем
стандартные свойства.

В случае отсутствия данного компонента на Вашем компьютере, обрабатываем
исключение связыванием с компонентом WebBrowser и запускаем скачивание
данного компонента с
http://activex.microsoft.com/activex/controls/sapi/spchapi.exe.

Если же на вашем компьютере уже установлены компоненты, произойдёт
инициализация TextToSpeech, который озвучит текущее время.

    var compon:TAxControl;
     
     procedure TForm1.FormCreate(Sender: TObject); 
     
    begin 
     
    try compon:=TAxControl.Create(self,stringtoguid('{EEE78591-FE22-11D0-8BEF-0060081841DE}')); 
    compon.Parent:=panel1; 
    compon.Visible:=true;
    compon.Top:=10; 
    compon.Left:=10;
    compon.Width:=100;
    compon.Height:=100; 
    compon.OleObject.Speak(timetostr(time));
     except form1.Caption:='установка SpeechAPI';
       messagebox(form1.Handle,'установи Speech API','ошибка',0);
       panel1.Width:=300; 
       panel1.Height:=250; 
    // компонент WebBrowser
       compon:=TAxControl.Create(self,stringtoguid('{8856F961-340A-11D0-A96B-00C04FD705A2}'));
       compon.Parent:=panel1; 
       compon.Visible:=true; 
       compon.Top:=20;
       compon.Left:=0; compon.OleObject.Navigate2('http://activex.microsoft.com/activex/controls/sapi/spchapi.exe.',0,0,00); 
     end; 
    end; 


Рассмотрим более подробно наиболее общие свойства и методы TextToSpeech:

    var Text:string;
    ...
    compon.OleObject.Speak(Text); //Произнести текст.  
     
    compon.OleObject.AboutDlg(form1.Handle,'о голосовом движке');// Выводит информацию о компоненте.  
     
    compon.OleObject.GeneralDlg(form1.Handle,'настройка'); // Выводит окно настройки компонента.
     
    compon.OleObject.LexiconDlg(form1.Handle,'пользовательский');//Окно подключения пользовательских словарей.
     
    compon.OleObject.Speed:=X; //Скорость речи. X=от 80 до 210.
     
    compon.OleObject.pitch:=X;// Тональность речи X=от 125 до 200.
     
    compon.OleObject.Select(X);//персоанаж X=1(Светлана) X=2(Борис)
     
    compon.OleObject.LipTension:=X;//визуальное положение губ X:= 0..255; 

В большинстве программ хватает этих свойств и методов. Но SpeechToText
некоторые слова произносит некорректно.

Для решения этой проблемы существует несколько путей:

- Подключение пользовательских словарей;
- Создание своих обработчиков;

Подключение словарей через вызов LexiconDlg, вручную, неудобно -
библиотеку типов этого модуля, лично я, не нашел.

Остаётся создание своего обработчика с вызовом методов:

    procedure TForm1.Button5Click(Sender: TObject); 
    begin 
     compon.OleObject.TextData(2,0,edit2.Text);//произнести фонемный код 
    end; 
     
    procedure TForm1.Button6Click(Sender: TObject);
     begin 
     edit2.Text:=compon.OleObject.Phonemes(2,10,edit1.Text);//преобразовать в фонемный код 
    end;


Используя фонетический алфавит Вы можете в широких пределах изменять
произношение. SpeechAPI компонент удобен для любителей
Web-программирования, так как поддерживает интерфейс IObjectSefety и
соответственно безопасен для использования в сценариях JavaScript и
VbScript. Пример использования в Web на сайте magdelphi.boom.ru

