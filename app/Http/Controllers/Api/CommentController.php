<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Validator;
use App\Http\Requests\Comment\CreateRequest;
use App\Jobs\AddNewComment;

class CommentController extends Controller
{
    /*public function store(Request $request) {
		$validator = Validator::make($request->all(), [
			'subject' => 'required|min:6',
            'body' => 'required|min:10',
            //'article_id' => 'required',
		]);
		
		//Если велидация провалилась, т.е. предложенные значения не соответствуют правилам, то можно передать от сервера json ответ
		if($validator->fails()) {
			return response()->json([
				'status' => 'error',
				'msg' => 'Error', //сообщение
				'errors' => $validator->errors(), //перечень ошибок
			], 422); //код 422 - Ошибка валидации  //422 Unprocessable Entity (Необработанная сущность)  ///4xx: Client Error (ошибка клиента)
		}
		
		////Если ошибок нет, то создаем новый комментарий
		
		//Передаем json со статусов успешно и кодом 200. И дальше работает Vue JS
		return response()->json([
            'status' => 'success',
        ], 201); //201 Created (создано)  ///2xx: Success (успешно)
	}*/
	
	//Первая грубая ошибка - это валидация в методе контроллера. Для того чтобы держать контроллеры чистыми, в Ларавел есть такая сущность как Реквест
	//Данный метод с помощью кастомного реквеста CreateRequest валидирует данные и если валидация прошла успешно, запускается джоб AddNewComment и создается новый комментарий. Если произошла ошибка валидации, то она сама вернется из кастомного реквеста со статусом 422 //422 Unprocessable Entity (Необработанная сущность)
	public function store(CreateRequest $request) {

        //По заданию создание комментария должно происходить в очереди. Это будет гаранировать на 100%-ное добавления нового комментария.В очередь отправляют тяжолые процессы такие как допустим отправка писем
		//Такие задачи, их называют Джобами, выполняются друг за другом и на каждую такую задачу можно выставить несколько попыток
		AddNewComment::dispatch($request['subject'], $request['body'], $request['article_id']);

        return response()->json([
            'status' => 'success',
        ], 201);

    }
}
