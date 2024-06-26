---
Title: DirectX (Игровой SDK) 1
Date: 01.01.2007
Author: Стас Бакулин (ogion@stud.vsu.ru)
---


DirectX (Игровой SDK) 1
=======================

:::{.right}
_Сидит как то программер, налаживает свою  
пятилетнюю работу, облoжился справочниками,  
доками, FAQ-ами.....неделю сидит - ни фига не  
получается. Мужик уже похудел весь, зарос  
щетиной... Входит в комнату его мама и говорит  
ему (с горечью в голосе):  
\- Hу... все играешь?_
:::

**Модель компонентных объектов (СОМ)**

Перед углублением и изнурительные подробности DirectDraw сначала
несколько слов о модели компонентных объектов - кратко СОМ. Delphi
использует объектно-ориентированный язык программирования Object Pascal.
Дизайнеры Delphi решили сделать родные Delphi объекты полностью
совместимыми с СОМ и OLE. Это большая новость для нас, потому что
DirectDraw использует интерфейс СОМ и поэтому из Delphi получить к нему
доступ достаточно просто.

Объекты СОМ подробно освещены в разделе Delphi. Но для того, чтобы
сэкономить ваше время, предоставлю краткий обзор. В Delphi вы работаете
с объектом СОМ практически так же, как и с другим объектом. Объекты СОМ
выглядят по сути как обычные объекты Delphi. Они имеют методы, которые
вы вызываете для доступа к их услугам. Тем не менее, они не имеют полей
или свойств. Главным отличием является то, что вы вызываете метод
Release вместо метода Free, если вы хотите освободить эти объекты.

Вы также никогда не создаете объект СОМ путем вызова конструктора.
Вместо этого вы вызываете функцию в DirectDraw для создания главного
объекта DirectDraw. Этот объект имеет дальнейшие методы, которые вы
используете для создания других методов. Помимо этих двух вопросов вы
можете фактически думать о них как об объектах Delphi.

Объекты СОМ DirectDraw определяются в довольно сложном файле-заголовке
на С, который поставляется с Game SDK. Однако я перевел это в модуль
импорта, который вы можете использовать в Delphi. Это файл DDraw.pas на
сопровождающем CD-ROM. Для того, чтобы получить доступ к DirectDraw,
просто добавьте DDraw в предложение uses.

**DirectDraw**

DirectDraw может оказаться довольно каверзным в использовании. На первый
взляд он кажется простым; существует только несколько СОМ-классов и они
не имеют большого количества методов. Однако DirectDraw использует
записи для определения всех видов различных параметров при создании
своих объектов. На первый взгляд они выглядят действительно устрашающе.
Вы можете найти их в справочных файлах Game SDK, начиная с букв DD,
например DDSurfaceDesc. Являясь API низкого уровня, существует множество
опций и параметров, которые допускают разницу в спецификациях
аппаратного обеспечения и возможностях. К счастью, в большинстве случаев
можно проигнорировать множеством этих опций. Самой большой проблемой в
момент написания этой книги является недостаток информации в GDK
документации, которая описывает, какие комбинации опций разрешаются,
поэтому для того, чтобы помочь вам найти путь через минное поле, эта
глава поэтапно проходит по всем стадиям создания приложения DirectDraw.
Я представляю код, который добавляется на каждом этапе и использует его
для объяснения аспекта DirectDraw, также как и рабочий пример, на
основании которого можно строить свои собственные программы.

**Объект IDirectDraw**

DLL с DirectDraw фактически имеет самый простой из интерфейсов. Она
экспортирует только одну функцию: DirectDrawCreate. Вы используете эту
функцию для создания СОМ-объекта IDirectDraw, который открывает
остальную часть API. Таким образом, первое, что должен сделать пример -
создать один из таких объектов. Вы делаете это в обработчике события
OnCreate формы и разрушаете его в OnDestroy. Лучшим местом хранения
объекта является приватное поле главной формы. Листинг 1 содержит
базовый код для осуществления этого.

**Листинг 1 Создание объекта IDirectDraw.**

    unit Uniti;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, DDraw;
     
    type
      TFormI = class (TForm)
        procedure FormCreate (Sender: TObject);
        procedure FormDestroy (Sender: TObject) ;
      private
        DirectDraw : IDirectDraw ; // главный объект DirectDraw
    end;
     
    var
      Formi: TFormI;
     
    implementation
     
    procedure TFormI. FormCreate (Sender: TObject);
    begin
      { создать СОМ-объект DirectDraw }
      if DirectDrawCreate( nil, DirectDraw, nil ) <> DD_OK then
        raise Exception. Create ( 'Failed to create IDirectDraw object' ) ;
    end;
     
    procedure TFormI. FormDestroy (Sender: TObject);
    begin
      { создать СОМ-объект DirectDraw эа счет вызова его метода Release }
      if Assigned ( DirectDraw ) then
        DirectDraw. Release ;
    end;
     
    end.

Вы можете скачать этот тривиальный пример DDDemo1 здесь (пока не можете,
я надеюсь это будет позже, прим. Lel). Он не делает что-либо очевидного,
когда вы запускаете его, поэтому не ожидайте слишком многого. Я включаю
его для того, чтобы показать, как мало кода требуется для создания и
освобождения СОМ-объекта DirectDraw. Это действительно очень просто.

**Коды возврата DirectDraw и исключения Delphi**

Подавляющее большинство функций DirectDraw возвращает результирующий код
целого типа с именем HResult, о котором вы можете думать как об integer.
Файл DDraw.pas имеет все возможные константы ошибок, занесенные в
список, а справочный файл Game SDK указывает на возможные коды ошибки,
возвращаемые каждой функцией. Вы можете проверить результаты этих
функций, и в болыпинстце случаев возбудить исключение, если результат
отличается от DD\_OK.

Однако имеется ряд проблем с использованием исключений, поскольку вы
переключаетесь на специальный экранный режим. Это означает, что вы не
способны видеть Delphi IDE, когда он разрушается или прерывается в
момент исключения, и ваша программа кажется замороженной. Установка
точки прерывания обычно приводит в результате к одной и той же проблеме:
приложение останавливается как раз в точке прерывания, но вы не имеете
возможность увидеть Delphi. Добро пожаловать в программирование игр в
среде Windows! Я обсуждаю это более подробно несколько позже.

**Переключение на полноэкранный режим**

Следующее, что необходимо сделать, - это переключить дисплей в режим
перелистывания страниц. Когда вы это делаете, становится видимым только
ваше приложение. Оно занимает весь экран. Любые другие приложения
Windows, которые находятся ц режиме выполнения, подобные Windows
Explorer, продолжают работать и могут записывать выходные данные на то,
что они считают экраном. Вы не видите, как выглядят выходные данные,
потому что другие приложения все еще используют GDI для выходных данных,
которому ничего не известно о DirectDraw. Но вам вовсе нет необходимости
беспокоиться об этом. GDI будет продолжать беспечно писать в экранную
память, хотя вы вдействительности не сможете увидеть его выходные
данные.

Путем переключения в специальный режим отображения данных вы занимаете
весь экран. Как правило, вы можете запускать множество регулярных
приложений среды Windows в одно и то же время; их окна перекрываются и
благодаря GDI дела идут прекрасно. Но что произойдет, если вы
попытаетесь запустить два и более полноэкранных DirectDraw-приложений в
одно и то же время? Ответ - только одному разрешен доступ к полному
экрану. DirectDraw управляет этим, предполагая, что вы имеете
исключительный доступ к экранной карте перед изменением режима. Вы
сделаете это установкой коиперативнчгн уровня объекта DirectDraw в
Exclusive. DirectDraw поддерживает эксклюзивный уровень доступа только
для одного приложения одновременно. Если вы попытаетесь получить
эксклюзивный доступ и какое-нибудь другое приложение уже его имеет,
вызов не удастся. Подобным же образом, если вы попытаетесь изменить
режимы отображения данных без приобретения эксклюзивного доступа, этот
вызов не удастся. Таким образом, попытайтесь получить эксклюзивный
доступ и затем переключите режимы отображения.

Здесь необходимо отметить, что вы должны предоставить описатель окна
SetCooperativeLevel. DirectDraw изменяет размеры этого окна
автоматически, так что оно заполняет экран в новом режиме отображения
данных. Вы должны передать описатель формы в SetCooperativeLevel. Ввиду
того, что описатель окна не был создан до времени вызова OnCreate, вы
должны все это сделать и событии OnShow. Листинг 2 показывает, как это
сделать.

**Листинг 2 Переключение в полноэкранный режим в OnShow.**

    procedure TForml.FormShow(Sender: TObject);
    begin
      if DirectDraw.SetCooperativeLevel(Handle,
      DDSCI_EXC: LUSIVE or DDSCI_FUbbSCREEN ) <> DD_OK then
        raise Exception.Create('Unable to acquire exclusive full-screen access');
     
      if DirectDraw.SetDisplayMode(640, 480, 8) <> DD_OK then
        raise Exception.Create('Unable to set new display mode');
    end;

Пока все в порядке. Ничего тут сложного нет. Если вы запустите пример
прямо сейчас, ваше приложение переключит режимы и вы увидите, как форма
заполнит экран. Если вы передвинете или измените ее размеры, вы увидите
за ним Delphi. Вы все еще смотрите на поверхность вывода GDI. GDI может
благополучно выводить данные в этих различных режимах, так что вы
увидите свои обычные приложения Windows так долго, сколько эта
поверхность будет оставаться на переднем плане. Но ввиду того, что вы
создаете приложение с мелькающими страницами, это не совсем то, что нам
нужно. Директория DDDemo2 содержит изложенные примеры

**Добавление обработчика исключений приложения**

Как я уже упоминал ранее, тот факт, что DirectDraw занимает полный экран
может вызвать проблему с обработкой исключений. Когда исключение
возбуждается, по умолчанию Delphi IDE попадает в отладчик программы и
приостанавливает исполнение программы, устанавливая кодовое окно на
строке, содержащей ошибку. Проблема заключается в том, что когда
происходит мелькание страниц вы, вероятно, не сможете увидеть IDE и
приложение будет выглядеть замороженным. Еще хуже, если вам удастся
продолжить исполнение, или на опции IDE окажется выключенной Break on
exception (Останавливаться, если возбуждено исключение), то вы можете не
увидеть окна сообщения, которое появляется с сообщением исключения.

Один из способов избежать этот сценарии отменить маркер на флажке Break
on exception в IDE (TooIsjOptions menu) и установить в своем приложении
специальный обработчик исключений приложения. Этот обработчик должен
переключаться на поверхность GDI перед тем, как показать сообщение
исключения. Это намного легче, чем может показаться. Все, что вам
необходимо сделать, - создать собственный private-метод в форме и
присвоить его AppHcation,OnException в OnCreate формы. Не забывайте
установить его обратно в nil в OnDestroy. Новый описатель может
использовать метод SwitchToGDISurface объекта IDirectDraw перед вызовом
MessageDIg. Листинг 3 показывает обработчик исключения.

**Листинг 3 Обработчик исключений приложения.**

    procedure TForml.ExceptionHandler(Sender: TObject; E: Exception);
    begin
      if Assigned(DirectDraw) then
        DirectDraw.FlipToGDISurface;
      MessageDIgt E.message, mtError, [mbOK], 0);
    end;

Для того, чтобы устаноцить описатель исключения мы добаиим следующую
строку в OnCreate:

    Application.OnException := ExceptionHandler;

Помните, что нужно выключить Break on exception (в TooIsfOptions). Как
только вы наберетесь больше опыта, вы сможете включить эту опцию снова
для специфических заданий отладки. Однако, если ваше приложение вызовет
исключение, пока поверхность GDI невидима, IDE возьмет свое и вы ничего
не увидите. Нажатие F9 должно вызвать повторное исполнение, а нажатие
Ctrl-F2 вернет приложение в исходное состояние и возвратит вас в
Delphi.
