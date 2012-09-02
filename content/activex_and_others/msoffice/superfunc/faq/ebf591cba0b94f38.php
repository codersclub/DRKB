<h1>Как напечатать документ с предварительной настройкой принтера?</h1>
<div class="date">01.01.2007</div>

<p>Для печати документа через диалог можно использовать элемент wdDialogFilePrint коллекции Dialogs, метод Show.W.Dialogs.Item(wdDialogFilePrint).Show; где wdDialogFilePrint=88; Если в этом диалоге использовать метод Execute, то будет запущена печать без диалога.</p>

