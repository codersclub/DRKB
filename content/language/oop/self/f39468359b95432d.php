<h1>В чем отличие между Create(Self) и Create(Application)?</h1>
<div class="date">01.01.2007</div>


<p>Self может быть использовано только в методе класса, и ссылается на текущий экземпляр класса. Таким образом "Self" в методе класса TForm1 ссылается на текущий экземпляр TForm1. При создании компонента Вы передаете его владельца (owner) в конструктор. При уничтожении формы или компонента автоматически уничтожаются и все компоненты владельцем которого она является. Таким образом если при создании формы передать в качестве владельца Application эта форма будет автоматически уничтожена при уничтожении Application. Если же при создании формы передать в качестве владельца другую форму, вновь созданная форма будет автоматически уничтоженна при уничтожении формы-владельца. </p>
