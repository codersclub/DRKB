<h1>Как научить приложение Delphi разговаривать?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Alec Bergamini</div>
<p>Совместимость: Delphi 5.x (или выше)</p>
<p>11-го августа 2001 Microsoft объявила о выпуске SAPI 5.1 SDK. Данный продукт можно использовать в любом языке, который поддерживает OLE автоматизацию.</p>
<p>В данной статье я постараюсь раасказать, как установить SAPI 5.1 SDK. Затем мы посмотрим, как использовать SDK в приложении Delphi для преобразования текста в синтезированную речь. Синтезированная речь будет проигрываться через спикер. Всё это тестировалось в Delphi 5 и 6.</p>
<p>Чтобы скачать SAPI 5.1, необходимо зайти на сайт Microsoft's Speech.net Technologies по адресу http://www.microsoft.com/speech/ и кликнуть по ссылке download. Далее будет предложено прочитать комментарии к данному продукту. Если в Вашей системе, язык по умолчанию отличается от US English, то настоятельно рекомендую прочитать эти комментарии до конца.</p>
<p>Если Вы используете beta версию операционной системы XP, то у Вас могут возникнуть некоторые проблемы. Проблемы связаны с тем, что большинство beta версий XP включают в себя ранние версии SAPI 5.1. Поэтому не пытайтесь инсталировать release версию SAPI 5.1 на XP, она не будет работать.</p>
<p>После того как Вы прочитаете комментарии, то приступайте к скачиванию Speech SDK 5.1. Всё что для этого потребуется, это нажать на ссылку Speech SDK 5.1 (68 MB). В архиве содержится сам SDK, докумантация, а так же текты на английском для примера.</p>
<p>Итак, после скачивания SAPI 5.1 SDK, запустите speechsdk51.exe для установки его на Ваш компьютер.</p>
<p>Теперь надо дать знать Delphi о новых объектах автоматизации SAPI. Для этого запустите Delphi 5 или 6 (Я не пробовал боле ранние версии) и откройте Project | Import Type Library. В диалоге Import Type Library выберите "Microsoft Speech Object Library (Version 5.1)". Если Вы не нашли его в списке, значит во время инсталяции SAPI 5.1 произошли какие-то ошибки.</p>
<p>Delphi предложит поместить компоненты SAPI на станицу ActiveX. Я рекомендую разместить их в новой странице под названием "SAPI 5", так как количество компонент довольно большое (19). Так же рекомендую Вам выбрать "Unit dir name" отличающуюся от той, которая предлагается по умолчанию. Убедитесь, что на "Generate Component Wrapper" стоит галочка и нажмите кнопку &gt;Install&lt;.</p>
<p>В диалоге Install выберите закладку "Into new package" и в поле "File name:" введите имя пакета наподобие "SAPI5.dpk", нажмите кнопку "Обзор..." (browse) и убедитесь, что dpk создан в той же директории, в которой были созданы компоненты. В диалоге Install в поле Description задайте какое-нибудь описание, например "SAPI 5 automation components". Нажмите OK</p>
<p>В подтверждающем диалоге нажмите yes. После этого новые компоненты будут установлены.</p>
<p>Теперь, если Вы посмотрите в директорию, которую указали для установки компонент, то обнаружите там файл SpeechLib_TLB.pas (и dcr) который содержит весь код компоненты (интерфайс, константы, типы, а так же другую полезную информацию). Эта директория так же содержит (если Вы следовали вышеприведённым инструкциям) SAPI5.dpk который является исходинком пакета.</p>
<p>А теперь самая интересная часть.</p>
<p>Давайте создадим приложение, которое будет синтезировать речь. В Delphi создайте новое приложение и поместите на форму кнопку. На странице компонент SAPI5 найдите SpVoice и перетащите его на форму.</p>
<p>Теперь создайте событие onClick для Вашей кнопки, которое должно выглядеть примерно так:</p>
<pre>procedure TForm1.Button1Click(Sender: TObject); 
begin 
  SpVoice1.Speak('Hello world!', SVSFDefault); 
end; 
</pre>

<p>Запустите программу и нажмите кнопку. Здорово?</p>
<p>Метод Speak объекта SPVoice предоставляет довольно большие возможности. Эти возможности можно использовать если поиграться со вторым параметром. В вышеприведённом примере я использовал режим поумолчанию, который позволяет функции вернуть управление только после завершения проигрывания звука. Избежать этого можно путём внедрения в текст специальных тэгов XML.</p>
<p>Документация по SDK содержит файл sapi.chm который можно найти в директории \Program Files\Microsoft Speech SDK 5.1\Docs\Help .</p>
<p>Sapi.chm содержит довольно много информации. Вот основные, часто используемые возможности компоненты и, соответствующие им флаги, которые передаются во втором параметре:</p>
<p>• Воспроизведение текста находящегося в файле. (SVSFIsFilename)</p>
<p>• Асинхронный решим проигрывания звука. Позволяет функции вернуть управление немедленно, во время воспроизведения. (SVSFlagsAsync)</p>
<p>• Позволяет управлять воспроизведением через XML тэги (см. раздел под название "XML TTS Tutorial"). Тэги позволяют настроить тональность звучания, скорость воспроизведения и многое другое.( SVSFIsXML)</p>
<p>Одна из интересных вещей (не документирована) заключается в том, что можно озвучивать заголовок веб страницы путём установки флага в SVSFIsFilenam а имени файла в URL. Если Вы соединены с интернетом, попробуйте запустить следующую строчку:</p>
<p>SpVoice1.Speak('http://www.o2a.com', SVSFIsFilename);</p>
<p>Так же при помощи этого флага можно проигрывать wav файлы:</p>
<p>SpVoice1.Speak('C:\WINNT\MEDIA\Windows Logon Sound.wav', SVSFIsFilename);</p>
<p>На самом деле у этой SAPI намного больше возможностей, чем я здесь привёл. В следующий раз, мы подробнее рассмотрим другие возможности.</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
