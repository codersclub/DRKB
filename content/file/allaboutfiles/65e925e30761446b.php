<h1>Файловые операции</h1>
<div class="date">01.01.2007</div>


<p>Дельфи предоставляет довольно широкие возможности по файловым операциям без использования механизмов открытия/закрытия файлов.</p>
<p>Вот список наиболее употребимых функций, большинство из которых в фачкстве параметров нуждаются только в имени файла:</p>
<p>ChDir(NewCurrentPath: string); - изменяет текущий каталог (в среде Windows сие конечно не так актуально как в ДОС, но все же), прочитать же текущий каталог можно функцией GetCurrentDir, а текущий каталог для определенного драйва - GetDir.</p>
<p>CreateDir(const Dir: string): Boolean; - создает каталог. При этом предыдущий уровень должен присутствовать. Если вы хотите сразу создать всю вложенность каталогов используйте функцию ForceDirectories(Dir: string): Boolean; Обе функции возвращают True если каталог создан</p>
<p>DiskFree(Drive: Byte): Int64; - дает свободное место на диске. Параметер - номер диска 0 = текущий, 1 = A, 2 = B, и так далее</p>
<p>DiskSize(Drive: Byte): Int64; - размер винта. Обратите внимание на то что для результата этой и предыдущей функций абсолютно необходимо использовать переменную типа Int64, иначе макимум того что вы сможете прочитать правильно будет ограничен 2Gb</p>
<p>FileExists(const FileName: string) - применяется для проверки наличия файла</p>
<p>FileGetAttr(const FileName: string): Integer;</p>
<p>FileSetAttr(const FileName: string; Attr: Integer): Integer; - функции для работы с атрибутами файлов. Вот список возможных атрибутов:</p>
<p>faReadOnly &nbsp; &nbsp; &nbsp; &nbsp;$00000001 &nbsp; &nbsp; &nbsp; &nbsp;Read-only files</p>
<p>faHidden &nbsp; &nbsp; &nbsp; &nbsp;$00000002 &nbsp; &nbsp; &nbsp; &nbsp;Hidden files</p>
<p>faSysFile &nbsp; &nbsp; &nbsp; &nbsp;$00000004 &nbsp; &nbsp; &nbsp; &nbsp;System files</p>
<p>faVolumeID &nbsp; &nbsp; &nbsp; &nbsp;$00000008 &nbsp; &nbsp; &nbsp; &nbsp;Volume ID files</p>
<p>faDirectory &nbsp; &nbsp; &nbsp; &nbsp;$00000010 &nbsp; &nbsp; &nbsp; &nbsp;Directory files</p>
<p>faArchive &nbsp; &nbsp; &nbsp; &nbsp;$00000020 &nbsp; &nbsp; &nbsp; &nbsp;Archive files</p>
<p>faAnyFile &nbsp; &nbsp; &nbsp; &nbsp;$0000003F &nbsp; &nbsp; &nbsp; &nbsp;Any file</p>
<p>(Естественно не все атрибуты применимы во всех случаях)</p>
<p>RemoveDir(const Dir: string): Boolean; - удаляет папку(пустую)</p>
<p>DeleteFile(const FileName: string): Boolean; - удаляет файл</p>
<p>RenameFile(const OldName, NewName: string) - переименовывает файл</p>

