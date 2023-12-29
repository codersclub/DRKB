---
Title: Что такое DirectShow?
Author: JINX (Elchin Aziz Ali OglI)
Date: 01.01.2007
---


Что такое DirectShow?
=====================

::: {.date}
01.01.2007
:::

На этот раз речь пойдет о DirectShow. Для чего нам может понадобиться
DirectShow?

DirectShow - это архитектура для воспроизведения, перехвата и обработки
потоков мультимедиа. Звучит туманно? Поясняю - c помощью этого API
можно:

проигрывать мультимедийные файлы различного формата, такие как MPEG
(Motion Picture Experts Group), AVI (Audio-Video Interleaved), MP3 (MPEG
Audio Layer-3), DVD и конечно WAV;

перехватывать видео-поток с различного рода TV-карт, видеокамер и т.п.;

создавать нестандартные обработчики мультимедиа-потоков и свои
собственные форматы файлов (что, впрочем, вряд ли понадобится простым
смертным);

обращаться непосредственно к видео и аудио потокам, чтобы выводить их на
Surface DirectDraw (что для нас как раз интересно).

Звучит заманчиво. Но для чего это может понадобиться, спросите Вы,
вспоминая родной и привычный MediaPlayer.  Представьте себе, что Вы
запрограммировали трехмерный мир, с анимированными спрайтами,
трехмерными объектами и т.п. И в отсвете выстрелов очередной
\"бродилки-стрелялки\", пораженный пользователь нового шедевра, видит
видео клип, воспроизводимый прямо на костях очередного пораженного
монстра. :-) Каково? Убедил? Тогда продолжим.

Кстати, раз уж упомянули DirectDraw - DirectShow интегрирован с DirectX
так, что использует DirectDraw и DirectSound для вывода изображения и
звука, и, при наличии аппаратного ускорения, автоматически им
воспользуется.

Для работы с DirectShow Вам понадобятся:

иметь некоторое представление о технологии COM (Component Object Model)
- хотя быть знатоком этой технологии вовсе не обязательно - просто
достаточно знать, что для получения COM-интерфейса нужно вызвать
QueryInterface;

скачать заголовочные файлы DirectShow API, переведенные на Delphi в
рамках проекта JEDI -
(http://www.delphi-jedi.org/DelphiGraphics/DirectX/DX5Media.zip) и либо
поместить их в каталог Delphi\\Lib либо добавить путь к каталогу, в
котором они находятся в установках Delphi Library Path.

DirectShow скорее всего уже установлен на Вашем компьютере - он входит в
стандартную поставку Windows 9x, Windows NT 4 (Service Pack 3 и выше),
Windows 2000 (если Вы программируете для UNIX или DOS - то я вообще не
понимаю зачем Вы читаете эту статью).

Основы DirectShow

В концепции DirectShow мультимедийные данные - это поток, который
проходит через несколько обрабатывающих блоков. Блоки, обрабатывающие
поток данных, передают данные по цепочке друг другу, таким образом можно
представить себе несколько \"устройств\", каждое из которых выполняет
какую-то обработку данных и передает их соседнему \"устройству\". Эти
\"устройства\" или \"блоки обработки\" данных называют фильтрами.
Цепочка, по которой передаются данные, содержит несколько фильтров,
связанных определенным образом.

В DirectShow имеются готовые фильтры, из которых, словно из детских
кубиков, программист может выстроить ту или иную цепочку обработку
данных, кроме того, конечно, можно создать свои, нестандартные фильтры.

Для создания такой \"цепочки обработки\" (которая, кстати, официально
называются Filter Graph - \"граф фильтров\" или, в несколько вольном
переводе - \"схема соединения фильтров\"), так вот для создания схемы
соединения фильтров, предназначен самый базовый и лежащий в основе всех
основ компонет DirectShow, под названием Filter Graph Manager - Менеджер
Графа Фильтров.

Например, программа показывающая видео из AVI-файла может построить
такой граф фильтров:

В этом примере пять фильтров, первый (File Source) просто читает данные
с диска, второй фильтр (AVI Splitter) разделяет данные на кадры и
передает упакованные видео данные фильтру AVI Decompressor, который их
распаковывает и передает фильтру Default DirectSound Device, выводящему
звук. AVI Decompressor передает распакованные данные фильтру Video
Renderer, который выводит кадры видео на экран.

Фильтры делятся на три типа:

Фильтры-источники (Source filters)  - эти фильтры просто получают данные
из какого-то источника, с диска (как фильтр File Source (Async) на
рисунке), с CD или DVD дисковода или с TV- карты или карты, к которой
подключена цифровая видеокамера.

Фильтры-преобразователи (Transform filters) - эти фильтры как видно из
названия преобразуют поток данных, проходящий через них каким-либо
образом, например - разделяет поток данных на кадры, производят
декомпрессию и т.п. На нашем рисунке к таким фильтрам относятся AVI
Splitter и AVI Decompressor.

Фильтры вывода (Renderer filters) - фильтры, которые получают полностью
обработанные данные и выводят их на монитор, звуковую карту, пишут на
диск или выводят на еще какое-нибудь устройство.

Итак из фильтров-кубиков можно высстраивать граф. Делается это с помощью
интерфейса IGraphBuilder. Создать объект типа IGraphBuilder можно так:

CoCreateInstance(CLSID\_FilterGraph,nil,CLSCTX\_INPROC\_SERVER,IID\_IGraphBuilder,MyGraphBuilder);

Здесь переменная MyGraphBuilder имеет тип IGraphBuilder; идентификатор
класса CLSID\_FilterGraph и IID\_IGraphBuilder обьявлены в файле
DShow.pas, поэтому не забудьте добавить

uses DShow.pas

Итак, интерфейс IGraphBuilder получен. Можно построить граф фильтров,
такой, какой нам нужно. Впрочем, все не так сложно, IGraphBuilder
достаточно интеллектуален, он может сам, автоматически, построить граф,
в зависимости от того какие файлы мы собираемся воспроизводить.
Интерфейс IGraphBuilder имеет метод RenderFile, который получает имя
файла в качестве параметра и, в зависимости от типа файла (которое
определяется по расширению и по специальным сигнатурам в файле),
сканирует реестр, в поисках необходимой для построения графа информации,
создает необходимые фильтры и строит граф, предназначенный для
воспроизведения файлов этого типа (WAV, AVI, MP3, MPG и т.д.).

После построения графа DirectShow готов к воспроизведению. Для
управления потоком данных через граф обработки предназначен интерфейс
IMediaControl - он имеет методы Run, Pause и Stop (названия говорят сами
за себя)

Давайте попробуем все это на примере:

    uses
      ... DShow, ActiveX,ComObj;
     
    var
      MyGraphBuilder : IGraphBuilder;
      MyMediaControl : IMediaControl;
    begin
     
    CoInitialize(nil);
    {получаем интерфейс IGraphBuilder}
    CoCreateInstance(CLSID_FilterGraph,nil,CLSCTX_INPROC_SERVER,IID_IGraphBuilder,MyGraphBuilder);
     
    {вызываем RenderFile - граф фильтров строится автоматически}
    MyGraphBuilder.RenderFile('cool.avi',nil);
     
    {получаем интерфейс ImediaControl}
    MyGraphBuilder.QueryInterface(IID_IMediaControl,MyMediaControl);
     
    {Примечание - MyMediaControl - переменная типа IMediaControl}
     
    {проигрываем видео}
    MyMediaControl.Run;
     
    {ждем пока пользователь не нажмет ОК (видео воспроизводится в отдельном (thread) потоке)}
    ShowMessage('Нажмите OК');
     
    CoUninitialize;
     
    end;

Если Вы не поленитесь скопировать этот кусок кода в Delphi и запустить
его то заметите, что avi-файл проигрывается в отдельном окошке, которое
не принадлежит нашему приложению. Для управления окошком, в котором
воспроизводится видео предназначен специальный интерфейс IVideoWindow.
Получить этот  интерфейс можно из экземпляра IGraphBuilder, вызвав
QueryInterface и передав в качестве идентификатора интерфейса константу
IID\_IvideoWindow.

Интерфейс IVideoWindow содержит методы для управления заголовком,
стилем, местоположением и размерами окошка в котором проигрывается
видео.

Давайте попробуем переделать наш пример так, чтобы видео выводилось не в
отдельном окошке, а, скажем на компоненте TPanel, расположенном в нашей
форме. Добавьте на форму компонет TPanel, пусть он называется Panel1.

    uses
      ... DShow, ActiveX,ComObj;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      MyGraphBuilder : IGraphBuilder;
      MyMediaControl : IMediaControl;
      VideoWindow : IVideoWindow;
     
    begin
     
    CoInitialize(nil);
    {получаем интерфейс IGraphBuilder}
    CoCreateInstance(CLSID_FilterGraph,nil,CLSCTX_INPROC_SERVER,IID_IGraphBuilder,MyGraphBuilder);
     
     
    {вызываем RenderFile - граф фильтров строится автоматически}
    MyGraphBuilder.RenderFile('C:\Program Files\Borland\Delphi5\Demos\Coolstuf\cool.avi',nil);
     
    {получаем интерфейс ImediaControl}
    MyGraphBuilder.QueryInterface(IID_IMediaControl,MyMediaControl);
    {Примечание - MyMediaControl - переменная типа IMediaControl}
     
    {получаем интерфейс IVideoWindow}
    MyGraphBuilder.QueryInterface(IID_IVideoWindow,VideoWindow);
    {Примечание - VideoWindow - переменная типа IVideoWindow}
     
    {располагаем окошко с видео на панель}
    VideoWindow.Set_Owner(Self.Panel1.Handle);
    VideoWindow.Set_WindowStyle(WS_CHILD OR WS_CLIPSIBLINGS);
    VideoWindow.SetWindowPosition(0,0,Panel1.ClientRect.Right,Panel1.ClientRect.Bottom);
     
    {проигрываем видео}
    MyMediaControl.Run;
     
    ShowMessage('Нажмите OК');
     
    CoUninitialize;
    end;

Надеюсь это проще, чем Вы ожидали?

DirectShow и DirectX

Для того, чтобы использовать DirectShow совместно с DirectShow нужно
разобраться с понятием Multimedia Streaming (потоки мультимедиа).

Multimedia Streaming - это архитектура, используемая в DirectShow для
облегчения жизни программиста. Эта архитектура позволяет работать с
мультимедиа данными, как с абстрактным потоком, не вдаваясь в
подробности форматов хранения мультимедиа-файлов или специфику
устройств-источников мультимедиа. Используя эту архитектуру, программист
концентрируется не на расшифровке и преобразовании данных, а на
управлении потоком данных, кадрами видео или аудио семплами.

На рисунке изображена иерархия объектов Multimedia Streaming

На вершине иерархии  находится базовый объект Multimedia Stream, который
является контейнером для объектов Media Stream. Объект Multimedia Stream
может содержать один или несколько объектов Media Stream. В то время как
каждый объект типа Media Stream предназначен для работы с данными
какого-то одного типа (видео, аудио и т.п.) - Multimedia Stream - просто
содержит методы для обращения к содержащимся в нем объектам Media Stream
и не зависит от типа данных.

Объект типа Stream Sample, доступ к которому можно получить из Media
Stream - позволяет управлять непосредственно элементами мультимедийного
потока (для видео каждый Sample - это кадр видеоизображения, для аудио
он может содержать несколько семплов звука).

Однако хватит теории. Давайте  перейдем к делу. Попробуем создать
необходимые объекты, чтобы вывести видео на Surface DirectX. Для этого
нам понадобится обращаться к кадрам видео изображения (т.е. к обьекту
типа Stream Sample). Значит, придется пройтись по всей цепочке иерархии,
чтобы добраться до обьектов StreamSample. Вообще цепочка обьектов,
которую предстоит создать выглядит так:

IAMMultiMediaStream

   + IDirectDrawMediaStream

          + IDirectDrawStreamSample

Сравните это с нашим рисунком. Как видите на вершине находится объект
типа MultiMediaStream, который будет содержать MediaStream конкретного,
нужного нам типа (IDirectDrawMediaStream), а уж с помощью него мы
получим доступ к конкретным видео кадрам через интерфейс
IDirectDrawStreamSample.

Итак сейчас мы создадим объект типа IAMMultiMediaStream. Этот интерфейс
унаследован от IMultimediaStream и содержит, кроме прочего, функцию
OpenFile, которая автоматически строит граф фильтров для воспроизведения
файла.

CoCreateInstance(CLSID\_AMMultiMediaStream, nil, CLSCTX\_INPROC\_SERVER,
IID\_IAMMultiMediaStream, AMStream);

Здесь переменная AMStream имеет тип IAMMultiMediaStream.

Мы создали контейнер для мультимедийных потоков. Сверяемся с рисунком -
мы на верхнем уровне иерархии. У нас есть объект типа IMultimediaStream
- теперь в этот контейнер нужно проинициализировать и добавить один или
несколько мультимедиа потоков, нужного нам типа. Сначала инициализация:

AMStream.Initialize(STREAMTYPE\_READ,

AMMSF\_NOGRAPHTHREAD, nil);

При инициализации указываем, что будут создаваться мультимедиа потоки
для чтения, передав значение STREAMTYPE\_READ (другие варианты
STREAMTYPE\_WRITE, STREAMTYPE\_TRANSFORM).

Создадим теперь мультимедиа потоки для видео и звука:

AMStream.AddMediaStream(DDraw, MSPID\_PrimaryVideo, 0,
NewMediaStremVideo);

   AMStream.AddMediaStream(nil, MSPID\_PrimaryAudio,
AMMSF\_ADDDEFAULTRENDERER, NewMediaStremAudio);

Вызываем метод OpenFile - файл загружается, и автоматически строится
граф фильтов:

AMStream.OpenFile(\'cool.avi\', 0);

Осталось направить видео поток мультимедиа поток на Surface. Вот
процедура, которая делает это:

    procedure TForm1.RenderStreamToSurface(Surface : IDirectDrawSurface; MMStream : IMultiMediaStream);
    var
    PrimaryVidStream : IMediaStream;
    DDStream  :  IDirectDrawMediaStream;
    Sample : IDirectDrawStreamSample; 
    RECT : TRect;
    ddsd :  TDDSURFACEDESC;
    Z : DWORD;
    begin
        MMStream.GetMediaStream(MSPID_PrimaryVideo, PrimaryVidStream);
        PrimaryVidStream.QueryInterface(IID_IDirectDrawMediaStream, DDStream);
        ddsd.dwSize := sizeof(ddsd);
        DDStream.GetFormat(ddsd, Palitra, ddsd, Z);
        rect.top:=(480-ddsd.dwHeight)div 2; rect.left:=(640 - ddsd.dwWidth) div 2;
        rect.bottom := rect.top+ddsd.dwHeight;    rect.right := rect.left+ddsd.dwWidth;
        DDStream.CreateSample(Surface, Rect, 0, Sample);
        MMStream.SetState(STREAMSTATE_RUN);
    end;

Как видите, в этой процедуре сначала получаем интерфейс типа
IDirectDrawMediaStream (соответствующий второму уровню иерархии на нашем
рисунке), потом из него получаем объект типа IDirectDrawStreamSample
(переменная Sample), который соответствует третьему уровню иерархии
нашего рисунка.

Теперь остается вызывать в цикле (в демо-программе это делается по
таймеру - здесь для простоты опускаем):

    hr:=Sample.Update(0, 0, nil, 0);
     
       if hr = $40003 {MS_S_ENDOFSTREAM} then
         MMStream.Seek(0);

Метод IDirectDrawStreamSample.Update выводит очередной кадр на Surface.
При достижении конца потока он вернет ошибку с кодом $40003
(MS\_S\_ENDOFSTREAM), я в этом случае просто перематываю поток к началу,
методом Seek.

Полностью программу, фрагменты кода из которой здесь приведены можно
скачать здесь \<\<URL\>\>.

В этой программе инициализируется DirectDraw, создается Surface, а
затем на него выводится видео из avi-файла.

Пока все о DirectDraw - надеюсь эта информация послужит для Вас
отправной точкой в написании чего-то потрясающего! :-)

Автор: JINX (Elchin Aziz Ali OglI)

EMail: aziz\@telebot.com, error\@softhome.net

CopyLeft 2000.

Взято с сайта Анатолия Подгорецкого  <https://podgoretsky.com>

по материалам fido7.ru.delphi.*
