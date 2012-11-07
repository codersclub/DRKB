<h1>Создание иконок из ресурсов</h1>
<div class="date">01.01.2007</div>


<p>Вот небольшая статейка, найденная мной в FAQ(<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a>). Может пригодится?</p>
<p>Функция CreateIconFromResourceEx создает иконку или курсор из битов ресурса, описывающих иконку.</p>
<p>перевод функции CreateIconFromResourceEx. CreateIconFromResourceEx Функция CreateIconFromResourceEx создает иконку или курсор из битов ресурса,</p>
<p>описывающих иконку. HICON CreateIconFromResourceEx( PBYTE pbIconBits, // указатель на биты ресурса</p>
<p>DWORD cbIconBits, // число бит в буфере</p>
<p>BOOL fIcon, // флаг иконки или курсора</p>
<p>DWORD dwVersion, // версия формата Windows</p>
<p>int cxDesired, // желаемая ширина иконки или курсора</p>
<p>int cyDesired, // желаемая высота иконки или курсора</p>
<p>UINT uFlags</p>
<p>); Параметры pbIconBits - указывает на буфер, содержащий биты ресурса иконки или курсора.</p>
<p>Эти биты обычно загружаются вызовами функций LookupIconIdFromDirectory (в Windows</p>
<p>95 вы также можете использовать функцию LookupIconIdFromDirectoryEx) и LoadResource.</p>
<p>cbIconBits - определяет размер, в байтах, набора битов, на который указывает</p>
<p>параметр pbIconBits.</p>
<p>fIcon - определяет, будет ли создаваться иконка или курсор. Если значение этого</p>
<p>параметра равно TRUE, создается иконка. Иначе создается курсор.</p>
<p>dwVersion - определяет номер версии формата иконки или курсора для битов ресурса,</p>
<p>на которые указывает параметр pbIconBits. Параметр может принимать одно из следующих</p>
<p>значений: Формат Значение</p>
<p>Windows 2.x 0x00020000</p>
<p>Windows 3.x 0x00030000 Все Win32 приложения должны использовать для иконок и курсоров формат Windows</p>
<p>3.x.</p>
<p>cxDesired - определяет желаемую ширину иконки или курсора в пикселях. Если значение</p>
<p>этого параметра равно нулю, функция использует значения метрики системы SM_CXICON</p>
<p>или SM_CXCURSOR для установки ширины.</p>
<p>cyDesired - определяет желаемую высоту иконки или курсора в пикселях. Если значение</p>
<p>этого параметра равно нулю, функция использует значения метрики системы SM_CXICON</p>
<p>или SM_CXCURSOR для установки высоты.</p>
<p>uFlags - определяет комбинацию из следующих значений: Значение Пояснение</p>
<p>LR_DEFAULTCOLOR Используется цветовой формат по умолчанию.</p>
<p>LR_MONOCHROME Создается монохромная иконка или курсор. Возвращаемые значения В случае успеха возвращается дескриптор иконки или курсора.</p>
<p>В случае неудачи возвращается нуль. Для получения дополнительной информации об</p>
<p>ошибке вызовите функцию GetLastError. Комментарии Функции CreateIconFromResourceEx, CreateIconFromResource, CreateIconIndirect,</p>
<p>GetIconInfo и LookupIconIdFromDirectoryEx позволяют приложениям оболочки и браузерам</p>
<p>иконок проверять и использовать ресурсы См. также BITMAPINFOHEADER, CreateIconFromResource, CreateIconIndirect, GetIconInfo, LoadResource,</p>
<p>LookupIconIdFromDirectoryEx . хелп по WinAPI: <a href="https://www.winnt.rsm.org.ru/winapi/win32api.exe" target="_blank">https://www.winnt.rsm.org.ru/winapi/win32api.exe</a></p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
