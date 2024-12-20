---
Title: Получаем и устанавливаем различные режимы видеоадаптера
Date: 01.01.2007
---


Получаем и устанавливаем различные режимы видеоадаптера
=======================================================

Вариант 1:

Source: <https://forum.sources.ru>

_Перевод одноимённой статьи с сайта delphi.about.com_

**Display Device Modes**

При разработке Windows приложения, иногда приходится учитывать тот факт,
что оно в будущем будет работать на компьютерах с абсолютно разными
мониторами и рабочими разрешениями, установленными на видео адаптере.
Поэтому не лишне было бы включить в приложение такую возможность как
установка различных разрешений видео адаптера.

В данной статье мы рассмотрим принципы работы с API функцией
EnumDisplaySettings, которая позволяет получить список доступных
разрешений дисплея, а так же с функцией ChangeDisplaySettings для смены
текущего видео-режима.

**Получение возможных видео-режимов**

Итак, для того, чтобы получить информацию о всех возможных режимах
адаптера, нам необходимо сделать серию вызовов функции
EnumDisplaySettings. Вызывая эту функцию в цикле мы будем каждый раз
получать доступный режим, до тех пор пока результат функции не станет
отличным от True.

Данная функция имеет на входе переменную типа TDevMode, в которой
помещаются параметры. Сам тип TDevMode имеет множество переменных,
относящихся к видео адаптеру. А именно, он включает в себя разрешение
видео адаптера в пикселях (dmPelsWidth, dmPelsHeight), разрядность цвета
(в битах на пиксель), поддерживаемая при данном разрешении
(dmBitsPerPel), частота обновления (dmDisplayFrequency) и другие.

    procedure TForm1.FormCreate(Sender: TObject);
    var
     i       : Integer;
     DevMode : TDevMode;
    begin
     i:=0;
     while EnumDisplaySettings(nil,i,DevMode) do begin
       with Devmode do
         ListBox1.Items.Add (Format('%dx%d %d Colors',
           [dmPelsWidth,dmPelsHeight,1 shl dmBitsperPel]));
       Inc(i);
     end;
    end;

**Установка видео-режима**

После того как мы получим все доступные режимы, то установить
желательный не составляет особого труда. Для этого мы воспользуемся
функцией ChangeDisplaySettings. Так же данная функция при необходимости
обновит реестр Windows.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      DevMode    : TDeviceMode;
      liRetValue : Longint;
    begin
      if EnumDisplaySettings
        (nil,Listbox1.ItemIndex,Devmode) then
        liRetValue := ChangeDisplaySettings(DevMode, CDS_UPDATEREGISTRY);
     
      SendMessage(HWND_BROADCAST,
                  WM_DISPLAYCHANGE,
                  SPI_SETNONCLIENTMETRICS,
                  0); 
    end;

Функция ChangeDisplaySettings возвращает значение long integer. Это
значение можно использовать для определения успешности выполнения
функции, сравнив со значениями из списка констант.

**Внимание:**
Не рекомендуется устанавливать значение видео-режима, который
не присутствует в списке доступных. Это может привести к мерцанию экрана
либо вообще к исчезновению изображения.

**Внимание:**
Многие адаптеры (особенно старые) могут не поддерживать смену
разрешения без перезагрузки компьютера.

**Внимание:**
SendMessage используется для того, чтобы информировать все
окна о смене видео-режима.

**Отслеживание изменений дисплея**

Для отслеживания изменений необходимо создать обработчик для перехвата
сообщения WM\_DISPLAYCHANGE. Обычно данный приём используется в случае,
если приложения использует в своей работе графику, и его необходимо
перезагрузить для смены разрешения, разрядности цвета и т.д.

    ...
    type
      TForm1 = class(TForm)
      ListBox1: TListBox;
        ...
      private
        procedure WMDisplayChange(var Message:TMessage);
          message WM_DISPLAYCHANGE;
    ...
    procedure
      TForm1.WMDisplayChange(var Message: TMessage);
    begin
      ShowMessage('Changes in display detected!');
      inherited;
    end;

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

При разработке приложений, которые затем будут использоваться на большом
числе различных ПК очень полезно иметь возможность не только получения
информации о текущем видеорежиме, но и возможность получить все
доступные видеорежимы для данного ПК. Еще одна область, где используется
переключение видеорежимов при написании игр без использования DirectX.

**Получение списка видеорежимов**

Получить видеорежимы можно серией вызовов EnumDisplaySettings. Функция
EnumDisplaySettings возвращает информацию о видеорежиме, указанном в
параметре IModeNode. Функции необходимо передать структуру типа
TDevMode, в которую будет записана информация о видеорежиме. Данная
структура имеет поля, характеризующие видеорежим: разрешение
(dmPelsWidth, dmPelsHeight), количество битов цветности (dmBitsPerPel),
частота обновления экрана (dmDisplayFrequency) и др.

    function EnumDisplaySettings(lpszDeviceName: PWideChar; iModeNum: DWORD;
             var lpDevMode: TdeviceMode): BOOL; stdcall;

Параметры

lpszDeviceName -
Указатель на нуль-терминальную строку, определяющую экранное устройство,
видеорежимы которого мы хотим получить. В Windows 95 and 98 (и в наших
приложениях :)) ), lpszDeviceName должно быть равно Nil.

iModeNum -
Номер видеорежима

lpDevMode -
Структура, в которой будет возвращена информация о видеорежиме.
Cтруктура довольно сложна и используется не только для видео устройств,
но нам понадобятся только следующие ее поля.

DmBitsPerPel -
Количество бит на пиксел

DmPelsWidth -
Ширина в пикселях

DmPelsHeight -
Высота в пикселях

DmDisplayFlags - флаги:

- DM\_GRAYSCALE - Черно-белое устройство
- DM\_INTERLACED - Черезстрочная развертка.

Если флаг не установлен, подразумевается построчная развертка

dmDisplayFrequency -
Частота обновления экрана

DmPosition -
Windows 98, Windows 2000: Номер монитора для конфигураций с несколькими
мониторами

DmFields -
Поле dmFields используется при смене видеорежима для указания, какие
именно из параметров устройства мы хотим изменить. Каждый бит поля
определяет необходимость смены одного из параметров.

Возможные значения:

- DM\_BITSPERPEL - Изменить количество бит на пиксель на значение указанное в поле dmBitsPerPel.
- DM\_PELSWIDTH - Изменить ширинку экрана на значение указанное в поле dmPelsWidth.
- DM\_PELSHEIGHT - Изменить выстоу экрана на значение указанное в поле dmPelsHeight
- DM\_DISPLAYFLAGS - Изменить флаги.
- DM\_DISPLAYFREQUENCY - Изменить частоту обновления dmDisplayFrequency.
- DM\_POSITION - Windows 98, Windows 2000: изменить номер монитора.

Если lpDevMode равно nil, из реестра берется информация о видеорежиме
установленном по умолчанию. Передавая в lpDevMode nil и в dwFlags 0
можно получить настройки текущего видеорежима.

Ниже приведена процедура, получающая и отображающая в ListBox все
возможные видеорежимы.

    procedure TForm1.FormCreate(Sender: TObject);
    var
      i: Integer;
      DevMode : TDeviceMode;
    begin
      i:=0;
      while EnumDisplaySettings(nil,i,DevMode) do
      begin
        with Devmode do
          ListBox1.Items.Add(Format('%dx%d %d Colors',
          [dmPelsWidth,dmPelsHeight,Int64(1) shl dmBitsperPel]));
        Inc(i);
      end;
    end;

**Получение параметров текущего видеорежима**

Помимо вызова EnumDisplaySettings инфомацию о текущем видеорежиме можно
получать и другими способами.

Получить количество битов цвета текущего
видеорежима можно и другим способом:

    GetDeviceCaps(Form1.Canvas.Handle, BITSPIXEL)
      * GetDeviceCaps(Form1.Canvas.Handle, PLANES)

Получаемые значения при этом:

- 1 = 2 бита на точку
- 4 = 16 бита на точку
- 8 = 256 бита на точку
- 15 = 32768 бита на точку (возвращает 16 для большинства драйверов экранных устройств)
- 16 = 65535 бита на точку 
- 24 = 16,777,216 бита на точку 
- 32 = 16,777,216 бита на точку (то же 24)

Непосредственно количество цветов можно так же легко подсчитать:

    NumberOfColors := (1 shl (GetDeviceCaps(Form1.Canvas.Handle, BITSPIXEL)
                   * GetDeviceCaps(Form1.Canvas.Handle, PLANES));

Текущее разрешение экрана можно узнать с помощью вызова
GetSystemMetrics() в качестве параметров передается:

- SM\_CXSCREEN - высота рабочей области экрана в пикселах
- SM\_CYSCREEN - ширина рабочей области экрана в пикселах
- SM\_CXFULLSCREEN - высота всей экранной области в пикселах
- SM\_CYFULLSCREEN - ширина всей экранной области в пикселах

Ниже приведен пример получения высоты и ширины рабочей области экрана
(для всей экранной области надо просто поменять параметры вызова
GetSystemMetrics):

    var
      x, y: Integer;
      Mode: string;
    begin
      x:=GetSystemMetrics(Sm_Cxscreen);
      y:=GetSystemMetrics(Sm_CYscreen);
      Mode:=Format('%d x %d',[x,y]);
      if y=480 then
        Mode:=Mode+('Standard VGA')
      else
        Mode:=Mode+('Super VGA');
      StaticText1.Caption:=Mode;
    end;

**Установка видеорежима**

Как мы убедились получения списка и параметров видеорежимов не проблема.
Теперь разберемся с программной сменой видеорежимов. Функция
ChangeDisplaySettings предназначена для изменения текущего видеорежима
экрана и при необходимости обновления этой информации в реестре Windows.

    function ChangeDisplaySettings(var lpDevMode: TDeviceMode;
             dwFlags: DWORD): Longint; stdcall;

Параметры:

lpDevMode -
Структура с описанием видеорежима, на который мы хотим переключиться.
Поля структуры были рассмотрены ранее.

dwFlags -
Определяет как будет изменен видеорежим:

- 0 - Немедленное изменение видеорежима. Установка данного флага
возвращает в видеорежим по умолчанию, установленному в реестре, если он
был изменен с применением флага CDS\_FULLSCREEN, при этом первый
параметр функции должен быть nil и флаги равны 0.

- CDS\_UPDATEREGISTRY - Видеорежим будет изменен немедленно и информация
записана в реестр в пользовательский профиль.
- CDS\_TEST - Запрос теста видеорежима средствами Windows
- CDS\_FULLSCREEN - Установка видеорежима временна.
- CDS\_GLOBAL - Видеорежим будет изменен для всех пользователей данной
машины. Иначе видеорежим меняется только для текущего пользователя.
Используется вместе с флагом CDS\_UPDATEREGISTRY.
- CDS\_SET\_PRIMARY - Видеорежим становится первичным.
- CDS\_RESET - Параметры видеорежима будут изменены, даже если совпадают с
текущими.
- CDS\_NORESET - Изменения будут записаны в реестр, но не вступят в силу.
Используется с флагом CDS\_UPDATEREGISTRY

Возвращаемое значение:

- DISP\_CHANGE\_SUCCESSFUL Изменения прошли успешно.
- DISP\_CHANGE\_RESTART Необходима перезагрузка для вступления изменений в силу
- DISP\_CHANGE\_BADFLAGS Передан неверный набор флагов
- DISP\_CHANGE\_BADPARAM Неверные параметры.
- DISP\_CHANGE\_FAILED Драйвер видеоустройства не смог установить режим
- DISP\_CHANGE\_BADMODE Видеорежим не поддерживается
- DISP\_CHANGE\_NOTUPDATED Windows NT/2000: Ошибка записи в реестр

При немедленном изменении видеорежима всем запущенным приложениям
рассылается сообщение WM\_DISPLAYCHANGE.

А вот и пример смены видеорежима:

    {...}
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        ListView1: TListView;
        procedure Button1Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure ListView1DblClick(Sender: TObject);
      private
        { Private declarations }
        {Массив для хранения информации о видеорежимах}
        DevMode : array[0..20] of TDeviceMode;
      public
        { Public declarations }
    end;
     
    {...}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      {Настройка ListView}
      ListView1.ViewStyle := vsReport;
     
      ListView1.RowSelect := TRUE;
     
      ListView1.Columns.Add;
      ListView1.Columns.Add;
      ListView1.Columns[0].Caption := 'Width x Height';
      ListView1.Columns[0].Width := 100;
      ListView1.Columns[1].Caption := 'Colors';
      ListView1.Columns[1].Width := 100;
    end;
     
    {Процедура получения списка режимов}
    procedure TForm1.Button1Click(Sender: TObject);
    var
      tmpStr1, tmpStr2 : string;
      tmpDC : HDC;
      x, Selection, cxScreen, cyScreen, Resolution : Integer;
    begin
      { Запоминаем текущие настройки}
      tmpDC := getDC(Handle);
      try
        cxScreen := GetSystemMetrics(SM_CXSCREEN);
        cyScreen := GetSystemMetrics(SM_CYSCREEN);
        Resolution := GetDeviceCaps(tmpDC, BITSPIXEL);
      finally
        ReleaseDC(Handle, tmpDC);
      end;
     
      ListView1.Items.Clear;
      x := 0;
     
      { Получаем список видеорежимов}
      while EnumDisplaySettings(nil,x,DevMode[x]) do
      begin
     
        { Разрешение экрана }
        tmpStr1 := IntToStr(DevMode[x].dmPelsWidth) + 'x' +
                   IntToStr(DevMode[x].dmPelsHeight);
     
        { Цвета }
        case DevMode[x].dmBitsPerPel of
          4 : tmpStr2 := '16 Colors';
          8 : tmpStr2 := '256 Colors';
          16 : tmpStr2 := 'High Color (16 Bit)';
          32 : tmpStr2 := 'True Color (32 Bit)';
        end;
     
        { А теперь полученную информацию надо отобразить }
        with ListView1.Items.Add do
        begin
          Caption := tmpStr1;
          SubItems.Add(tmpStr2);
        end;
     
        { В ListView надо встать не строку с описанием текущего режима,
          для этого сохраним индекс элемента с описанием этого режима }
        if ( cxScreen = DevMode[x].dmPelsWidth ) and
           ( cyScreen = DevMode[x].dmPelsHeight ) and
           ( Resolution = DevMode[x].dmBitsPerPel ) then
          Selection := x;
     
        inc(x);
     
        if x = 20 then
          Break;
      end;
     
      { В ListView перемещаемся на строчку с описанием текущего режима }
      ActiveControl := ListView1;
      ListView1.Selected := ListView1.Items.Item[Selection];
    end;
     
     
    {Установка выбранного пользователем видеорежима}
    procedure TForm1.ListView1DblClick(Sender: TObject);
    var
      tmpDevMode : TDevMode;
    begin
      { Получаем сохраненную ранее информацию по выбранному режиму}
      tmpDevMode := DevMode[ListView1.Items.IndexOf(ListView1.Selected)];
     
      { Скажем Windows, какие параметры надо сменить }
      tmpDevMode.dmFields := DM_BITSPERPEL or DM_PELSWIDTH or
        DM_PELSHEIGHT or DM_DISPLAYFLAGS or DM_DISPLAYFREQUENCY;
     
      { Очень неплохо будет протестировать видеорежим
        и записать изменения в реестр}
      if ChangeDisplaySettings(tmpDevMode, CDS_TEST) = DISP_CHANGE_SUCCESSFUL then
        ChangeDisplaySettings(tmpDevMode, CDS_UPDATEREGISTRY);
    end;

**Замечание 1:**

Не рекомендуется устанавливать видеорежимы, отличные от полученных
вызовами EnumDisplaySettings. Возможна ситуация, когда пользователь
вместо рабочего стола увидит лишь черный экран.

**Замечание 2:**

Многие драйвера, особенно старые не поддерживают изменения видеорежима
без перезагрузки компьютера.

**Обнаружение изменений видеорежима**

При изменениях видеорежима генерируется сообщение WM\_DISPLAYCHANGE.
Необходимо создать обработчик данного сообщения в вашем приложении.

    ...
    type
      TForm1 = class(TForm)
      ListBox1: TListBox;
    ...
    private
      procedure WMDisplayChange(var message:TMessage); message WM_DISPLAYCHANGE;
    ...
     
    procedure TForm1.WMDisplayChange(var message: TMessage);
    begin
      ShowMessage('Changes in display detected!');
      inherited;
    end;

