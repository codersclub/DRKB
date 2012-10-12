<h1>Введение</h1>
<div class="date">01.01.2007</div>


<p>Понимание потоковых моделей в COM при программировании на Delphi </p>

<p class="author">Автор: Бин Ли </p>

<p>Я всегда твердо верил, что нет ничего такого, что было бы невозможно понять. Необходимо только "выпарить" наиболее сложные части проблемы и потратить какое-то количество времени на понимание частей проблемы "кусок за куском". Затем эти части собрать вместе и понять проблему целиком. </p>

<p>Введение </p>

<p>Потоковые модели в COM имеют репутацию наиболее сложных для понимания. Возможно потому, что множество имеющейся документации по этой теме имеет "техническую природу" или ориентировано на конкретный язык, чаще всего C или C++. Цель этой статьи - дать Вам возможность понять, почему потоковые модели в COM так важны и как правильно использовать потоковые модели в Ваших приложениях COM. Моя цель - представить Вам материал таким образом, чтобы Вы могли читать его последовательно от начала до конца и в результате понять всю статью. Сказав это, я бы настойчиво рекомендовал Вам не пропускать ни одной страницы в процессе чтения, чтобы у Вас не возникло трудностей оттого, что Вы что-то пропустили раньше. А теперь, я желаю Вам удачи, и не говорите, что я не предупреждал Вас об этом!</p>
<p>Прежде, чем начать изложение, давайте начнем с того, что поймем, почему потоковые модели так важны для Ваших приложений COM. Исходя из своего опыта, я могу сказать, что наиболее существенной причиной использования потоковых моделей является повышение общей производительности и скорости реакции Вашей программы, особенно для объектов серверов COM, которые используются для обслуживания большого количества клиентских приложений. Но я не хочу сказать, что использование потоковых моделей в Ваших объектах серверов COM всегда увеличивает производительность. Вы должны тщательно изучить, как используются Ваши объекты и как потоковая модель повлияет на производительность приложения и целостность данных. Я должен подчеркнуть, что вопросы целостности обязательно должны рассматриваться объектов при принятии решения, применять или нет потоковую модель.</p>
<p>Несмотря на то, что Вы можете думать, что использование потоковой модели существенно повысит производительность объекта, может оказаться, что Ваши объекты сильно зависят, скажем, от третьих библиотек, которые могут "не выжить" в условиях многопоточности. Другой хорошей причиной применения многопоточности может быть то, что задача по своей природе является весьма пригодной для многопоточной реализации. Например, серверные объекты, являющиеся чисто служебными объектами, вероятно, могут сильно зависеть от времени при выполнении операций или захватывании ресурсов. Примерами таких объектов являются мониторы работы оборудования, объекты пакетной обработки или даже простые объекты манипулирования данными, время исполнения которых для успешного завершения непредсказуемо. В этих случаях тип разрабатываемого Вами приложения по существу определяет использование многопоточности.</p>
<p>Имеется множество других причин, при которых Вы могли бы использовать многопоточность, но две упомянутые выше причины являются наиболее общими среди наблюдаемых в промышленном программировании. </p>
<p>С другой стороны, я бы хотел предупредить, что не стоит применять многопоточность, если Вы не нуждаетесь в ней или не можете понять преимущества получаемого при этом решения. Это означает, что Вам не стоит даже думать о многопоточности, если Вы думаете только о том, что это круто. Поверьте мне, использование мнопоточности существенно усложняет Ваше приложение и, если Вы недостаточно все продумали, Вам придется искать ошибки в тех местах программы, которые прекрасно работали в однопоточном исполнении.</p>
