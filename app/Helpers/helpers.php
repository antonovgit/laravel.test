<?php

//В чем проблема таких ф-ций? Являются ли они полноценными хэлерами? Данные из ф-ций жестко привязаны к конкретному сайту и они не универсальны. Здесь жестко прописаны роуты сайта и название класса
if (! function_exists('activeMainLink')) {
    function activeMainLink() {
        if(request()->is('/')) {
            return 'menu-link__active';
        }
        return '';
    }
}

if (! function_exists('activeArticleLink')) {
    function activeArticleLink() {
        if((request()->is('articles') or request()->is('articles/*'))) {
            return 'menu-link__active';
        }
        return '';
    }
}

//Данная ф-ция является 100%-ным хэлером. У данной ф-ции нет привязки к конкетному сайт, она абсолютно универсальна
//Данная ф-ция изменяет форму слова в зависимости от числа. Вы на сайте хотите вывести кол-во комментариев к статье, у вас 0 комментариев, 1 комментарий, 2 комментария, 5 комментариев. Соответственно вам необходимо правильно изменять форму слова "комментарий"
//https://gist.github.com/nicksas/88820b0ec83c9502274d6e8043ca695c
if (! function_exists('true_wordform')) {
    /*
 * $num число, от которого будет зависеть форма слова
 * $form_for_1 первая форма слова, например Комментарий
 * $form_for_2 вторая форма слова - Комментария
 * $form_for_5 третья форма множественного числа слова - Комментариев
*/
    function true_wordform($num, $form_for_0, $form_for_1, $form_for_2, $form_for_5) {
        $num = abs($num) % 100; // берем число по модулю и сбрасываем сотни (делим на 100, а остаток присваиваем переменной $num)
        $num_x = $num % 10; // сбрасываем десятки и записываем в новую переменную
        /*if ($num == 0) // если число принадлежит отрезку [11;19]
            return $form_for_0;*/
        if ($num > 10 && $num < 20) // если число принадлежит отрезку [11;19]
            return $form_for_5;
        if ($num_x > 1 && $num_x < 5) // иначе если число оканчивается на 2,3,4
            return $form_for_2;
        if ($num_x == 1) // иначе если оканчивается на 1
            return $form_for_1;
        return $form_for_5;
    }
}
