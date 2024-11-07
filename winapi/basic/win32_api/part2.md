---
Title: Существующие решения
Date: 01.01.2000
Author: Николай Мазуркин
Source: <https://forum.sources.ru>
---


Существующие решения
====================

Автору известны две объектно-ориентированные библиотеки, которые можно
рассматривать как альтернативу библиотеке VCL при написании компактных
программ. Это библиотеки классов XCL и ACL. Обе библиотеки бесплатны и
поставляются в исходных кодах.

|| 
--------------|-----------------------------
Библиотека ACL (API control library) | 
Автор:        |Александр Боковиков, Екатеринбург, Россия
Страничка:    |http://a-press.parad.ru/pc/bokovikov/delphi/acl/acl.zip
E-Mail:       |abb@adx.ru
Классы:       |TFont, TFonts, TControl, TWinControl, TStdControl, TLabel, TEdit, TListBox, TButton, TCheckBox, TComboBox, TGroupBox, TProgressBar, TKeyboard

||
--------------|-----------------------------
Библиотека XCL|(Extreme class library) | 
Автор:        |Vladimir Kladov (Mr.Bonanzas)
Страничка:    |http://xcl.cjb.net
E-Mail:       |bonanzas@xcl.cjb.net
Классы:       |XForm, XApplet, XCanvas, XPen, XBrush, XFont, ZDDB, ZHiBmp, ZDIBitmap, ZBitmap, ZIcon, ZGifDecoder, ZGif, ZJpeg, XLabel, XButton, XBevel, XPanel, XSplitPanel, XStatus, XGrep, XGroup, XCheckBox, XRadioBox, XPaint, XScroller, XScrollBox, XScrollBoxEx, XEdit, XNumEdit, XCombo, XGrid, XListView, XMultiList, XNotebook, XTabs, XTabbedNotebook, XCalendar, XGauge, XGaugePercents, XHysto, XHystoEx, XImageList, XImgButton, XTooltip, XCustomForm, XDsgnForm, XDsgnNonvisual, CLabel, CPaint, CButton, CEdit, CMemo, CCheckBox, CRadioBox, CListBox, CComboBox, ZList, ZMenu, ZPopup, ZMainMenu, ZPopupMenu, ZTimer, ZStrings, ZStringList, ZIniFile, ZThread, ZQueue, ZFileChange, ZDirChange, ZOpenSaveDialog, ZOpenDirDialog, ZTree, ZDirList, ZDirListEx, ZRegistry, ZStream, ZFileStream, ZMemoryStream, XStrUtils.pas, XDateUtils.pas, XFileUtils.pas, XWindowUtils, XPrintUtils, XShellLinks.pas, XJustOne.pas, XJustOneNotify.pas, XPascalUnit.pas, XSysIcons.pas, XCanvasObjectsManager, XRotateFonts, XFocusPainter, XFormsStdMouseEvents, XFormsStdKeyEvents, XFormAutoSizer, XAligner, XControlAutoPlacer, XMfcAntiFlicker, XSplitSizer, XResizeAntiFlicker, XCaretShower, XEditMouseSelect, XEditClipboard, XEditUndo, XListMouseSel, XListKeySel, XListEdit, ZNamedTags, XBtnRepeats, XBufLabels, XBackgrounds, XWndDynHandlers

Как видно из списка приведенных для каждой библиотеки классов, эти
библиотеки предендуют скорее не на помощь при написании программ с
использованием Win32 API, а пытаются создать более высокий уровень
абстракции чем API, по крайней мере в графической части (особенно это
относится к XCL). Более того, иерархия и перечень объектов совпадают с
соответствующими структурами в библиотеке VCL, что скорее всего связано
с желанием авторов обеспечить логическую совместимость с VCL при
построении программ на основе этих библиотек.

Данные библиотеки не обеспечивают минимального размера программы, за
счет того что предоставляют более высокий уровень абстракции. Они
являются компромисом между программированием с использованием VCL и
программированием на чистом API.

Можно выделить несколько недостатков присущих даже не столько указанным
библиотекам, а сколько решениям и принципам на которых они основаны.

- Несмотря на сравнительно малый размер получаемых программ, размер программ написанных с использованием только Win32 API был бы меньше.

- Помимо изучения Win32 необходимо изучение структуры классов, предлагаемых в этих библиотеках.

- Библиотека XCL не поддерживает механизм message-процедур.

- Архитектура этих библиотек, по мнению автора, является весьма громоздкой. Структуры и классы данных библиотек аналогичны структурам VCL, что приводит к неэффективности программ (ведь мы стараемся написать компактную программу, не так ли ?).

- Использование библиотеки ACL невозможно совместно с библиотекой VCL.

- Запутанность и большой размер классов наряду с "самодокументированным" кодом (то есть отсутствием файлов помощи) затрудняют изучение библиотек.

- Библиотеки разрабатываются и поставляются в частном порядке на некоммерческой основе, поэтому при разработке большого проекта на основе этих библиотек существует потенциальный риск отказа от поддержки. При этом вся тяжесть по устранению ошибок и развитию кода библиотеки ляжет на вас (если вы не вращаетесь в Delphi-сообществе).
