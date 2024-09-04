---
Title: Настройка монитора
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Настройка монитора
==================

Иногда требуется, чтобы программа работала при чётко заданных параметрах
монитора: разрешение, глубина цвета, частота обновления... Определить
текущее разрешение просто, достаточно обратиться к объекту TScreen и
посмотреть значения его полей Width и Height. А вот чтобы установить
свои значения требуется обратиться к функции Api: ChangeDisplaySettings.
Если мы хотим вернуть текущие настройки по завершении работы программы,
то перед вызовом изменений надо запомнить эти настройки например таким
образом:

    uses ShellApi;
    var
      DefWidth, DefHeight, BPP: word;
    ...
     
    procedure SaveSettings;
    var
      DC: hDC;
    begin
      DefWidth := Screen.Width;
      DefHeight := Screen.Height;
      DC := CreateDC('DISPLAY', nil, nil, nil);
      BPP := GetDeviceCaps(DC, BITSPIXEL);
    end;

После этого можно устанавливать свои параметры. Для упрощения
собственной жизни я написал небольшую процедуру, которой надо только
передать желаемые параметры и она их либо установит, либо сообщит о
невозможности их установки.

    procedure SetScreen(BPP:byte;width,height,FR:integer);
    var
      D: TDevMode;
      h: HWND;
    begin
      h:=0;
      D.dmDeviceName:='DISPLAY';
      D.dmBitsPerPel:=BPP;
      D.dmDisplayFrequency:=FR;
      D.dmPelsWidth:=Width;
      D.dmPelsHeight:=Height;
      D.dmFields:=DM_BITSPERPEL+DM_PELSWIDTH+DM_PELSHEIGHT+DM_DISPLAYFREQUENCY;
      D.dmSize:=SizeOf(D);
      if ChangeDisplaySettings(D,CDS_TEST)=DISP_CHANGE_SUCCESSFUL then
        ChangeDisplaySettings(D,CDS_UPDATEREGISTRY)
      else
        MessageBox(h,'This mode is not supported by your video.',
        'Failed to change mode', MB_ICONWarning);
    end;

Вызывается так:

    SetScreen(глубина цвета, разрешение по горизонтали, разрешение по вертикали, частота в герцах);

Например:

    SetScreen(16,800,600,80); {16 бит цвет, 800х600, 80Гц.}

При завершении программы для восстановления старых параметров вызываем
эту процедуру с сохраненными ранее значениями:

    SetScreen(BPP,DefWidth,DefHeight,80);

Я не стал здесь беспокоиться о сохранении/возвращении частоты
обновления, а сразу установил 80Гц, но если кто желает, может сохранить
и этот параметр при запуске

    DefFR:=GetDeviceCaps(DC, VREFRESH);

и восстановить при закрытии программы:

    SetScreen(BPP,DefWidth,DefHeight,DefFR);

Пример применения этой возможности можно посмотреть в моей программе
SDisplay, которая вешается в трей и позволяет быстро изменить параметры
экрана.

