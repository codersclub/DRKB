---
Title: Глобальный класс TApplication
Date: 01.01.2007
Author: Михаил Христосенко
Author: Development и Дельфи (http://delphid.dax.ru/).
---


Глобальный класс TApplication
=============================

Предлагаю вам ознакомиться с приведенной таблицей событий этого объекта:

| Событие:Тип                   | Возникает                        |
|-------------------------------|----------------------------------|
| OnActionExecute: TActionEvent | Происходит при вызове метода Execute перед обработкой списка событий. |
| OnActionUpdate: TNotifyEvent  | Происходит при вызове метода Update; |
| OnActivate: TNotifyEvent      | При переходе приложения в активное состояние. |
| OnDeactivate:TNotifyEvent     | При переключении на другое приложение Windows |
| OnException: TExceptionEvent  | При возникновении исключительной ситуации |
| OnHelp: THelpEvent            | При запросе приложением справочной системы. |
| OnHint: TNotifyEvent          | При перемещении мыши над компонентом, у которого есть строка подсказки (Hint)          |
| OnIdle: TNotifyEvent          | При отсутствии работы у приложения                       |
| OnMessage: TMessageEvent      | При получении сообщения Windows  |
| OnMinimize: TNotifyEvent      | При минимизации приложения       |
| OnRestore: TNotifyEvent       | При восстановлении приложения в нормальный размер                |
| OnShowHint: TShowHintEvent    | При выводе строки подсказки (Hint)                           |

Для примера хочу предложить вам пример программы, которая при простое
увеличивает счетчик на единицу, а при нажатии клавиши перестает это
делать. Поставьте на форму одну кнопку и метку. Свойство Caption метки
должно быть равно \'0\';

    unit Unit1;
    interface
     
    uses
    Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
    StdCtrls;
     
    type
    TForm1 = class(TForm)
      Button1: TButton;
      Label1: TLabel;
      procedure Button1Click(Sender: TObject);
    private
    { Private declarations }
      procedure count(Sender:TObject; var Done:boolean);
      procedure stop(var Msg:TMsg; var Handled:boolean);
    public
    { Public declarations }
    end;
     
    var
    Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
    procedure Tform1.Count;
    begin
      label1.Caption:=IntToStr(StrToInt(label1.caption)+1);//увеличиваем счетчик
      Done:=false;
    end;
     
    procedure TForm1.stop(var Msg:Tmsg; var Handled:boolean);
    begin
      if Msg.message=WM_KEYDOWN then 
      begin //нажата любая клавиша
        Application.OnMessage:=nil;//сообщение не обрабаьывать
        Application.OnIdle:=nil;//Отменить фоновую работу
        Handled:=true;//сообщение обработано
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Application.OnIdle:=count;//процедура обработки простоя
      Application.OnMessage:=Stop;//процедура обработки сообщений
    end;
     
    end.

Еще у объекта TApplication есть ряд полезных свойств.
Их названия и смысл приведены в таблице.

Свойство:Тип            |Описание
------------------------|------------
HelpFile: String        |Имя файла контекстной помощи, которое используется приложением
Hint: String            |Строка подсказки
HintHidePause: Integer  |Время, в течении которого подсказка будет отображаться. По умолчанию 2500 мсек.
HintPause: Integer      |Время, через которое подсказка появится при перемещении курсора над объектом. По умолчанию 500 мсек.
HintShortPause: Integer |Используется для уменьшения мерцания курсора при перемещении мыши над объектом. По умолчанию 50 мсек.
ShowHint: Boolean       |Разрешает выводить подсказку для всего приложения (по умолчанию). Установив в False, вы запретите вывод подсказок для всего приложения

