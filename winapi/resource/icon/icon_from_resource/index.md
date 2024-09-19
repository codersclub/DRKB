---
Title: Создание иконок из ресурсов
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---

Создание иконок из ресурсов
===========================

Вот небольшая статейка, найденная мной в FAQ
(<https://blackman.km.ru/myfaq/cont4.phtml>).
Может, пригодится?

Функция CreateIconFromResourceEx создает иконку или курсор из битов
ресурса, описывающих иконку.

перевод функции CreateIconFromResourceEx.

CreateIconFromResourceEx - Функция CreateIconFromResourceEx
создает иконку или курсор из битов
ресурса, описывающих иконку.

```delphi
HICON CreateIconFromResourceEx(
        PBYTE pbIconBits, // указатель на биты ресурса
        DWORD cbIconBits, // число бит в буфере
        BOOL fIcon, // флаг иконки или курсора
        DWORD dwVersion, // версия формата Windows
        int cxDesired, // желаемая ширина иконки или курсора
        int cyDesired, // желаемая высота иконки или курсора
        UINT uFlags
);
```

Параметры pbIconBits - указывает на буфер, содержащий биты ресурса
иконки или курсора.

Эти биты обычно загружаются вызовами функций LookupIconIdFromDirectory
(в Windows 95 вы также можете использовать функцию LookupIconIdFromDirectoryEx) и
LoadResource.

cbIconBits - определяет размер, в байтах, набора битов, на который
указывает параметр pbIconBits.

fIcon - определяет, будет ли создаваться иконка или курсор. Если
значение этого параметра равно TRUE, создается иконка. Иначе создается курсор.

dwVersion - определяет номер версии формата иконки или курсора для
битов ресурса, на которые указывает параметр pbIconBits.
Параметр может принимать одно из следующих значений:

Формат      |Значение
------------|-----------------
Windows 2.x |0x00020000
Windows 3.x |0x00030000

Все Win32 приложения должны использовать для
иконок и курсоров формат Windows 3.x.

cxDesired - определяет желаемую ширину иконки или курсора в пикселях.
Если значение этого параметра равно нулю,
функция использует значения метрики системы SM\_CXICON
или SM\_CXCURSOR для установки ширины.

cyDesired - определяет желаемую высоту иконки или курсора в пикселях.
Если значение этого параметра равно нулю,
функция использует значения метрики системы SM\_CXICON
или SM\_CXCURSOR для установки высоты.

uFlags - определяет комбинацию из следующих значений:

Значение         |Пояснение
-----------------|----------------
LR\_DEFAULTCOLOR |Используется цветовой формат по умолчанию.
LR\_MONOCHROME   |Создается монохромная иконка или курсор.

**Возвращаемые значения:**

В случае успеха возвращается дескриптор иконки или курсора.  
В случае неудачи возвращается нуль.

Для получения дополнительной
информации об ошибке вызовите функцию GetLastError.

**Комментарии**

Функции CreateIconFromResourceEx, CreateIconFromResource, CreateIconIndirect,
GetIconInfo и LookupIconIdFromDirectoryEx позволяют приложениям оболочки
и браузерам иконок проверять и использовать ресурсы.

**См. также:**

BITMAPINFOHEADER, CreateIconFromResource, CreateIconIndirect, GetIconInfo, LoadResource,
LookupIconIdFromDirectoryEx.

хелп по WinAPI: <https://www.winnt.rsm.org.ru/winapi/win32api.exe>

