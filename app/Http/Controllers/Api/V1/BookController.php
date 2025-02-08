<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Models
use App\Models\{
    Book
};
//Requests
use App\Http\Requests\Books\FormData;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     *
     * This method handles the retrieval of books with optional search, pagination, and eager loading of relationships.
     * - 'search': A string to filter books by name.
     * - 'take': An integer to specify the number of books per page (default is 15).
     * - 'with': An array of relationships to eager load.
     *
     * The method returns a paginated list of books, ordered by ID in descending order.
     * In case of an error, it logs the error message and line number, and returns a 500 error response.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $justMyBooks= $request->input('justMyBooks');
            $take = $request->input('take') ?? 15;
            $with = $request->input('with') ?? [];
            $query = Book::query();
            $query->orderBy('id', 'desc');
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }
            if ($with) {
                $query->with($with);
            }
            if($justMyBooks){
                $query->where('user_id', auth()->user()->id);
            }
            $results = $query->paginate($take);
            return $this->pagination($results);
        } catch (\Exception $e) {
            return $this->error(__('books.error_list'), 500);
        }
    } //end of index method
    /**
     * Store a newly created book in storage.
     *
     * @param  \App\Http\Requests\FormData  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     *
     * This method handles the creation of a new book record. It extracts the necessary
     * data from the request, adds the authenticated user's ID to the data, and attempts
     * to create a new book record in the database. If successful, it returns a JSON response
     * with the created book data and a success message. If an exception occurs, it logs the
     * error details and returns a JSON response with an error message.
     */

    public function store(FormData $request)
    {
        try {
            $data = $request->only(['name', 'author', 'summary']);
            $data['user_id'] = auth()->user()->id;
            $book = Book::create(attributes: $data);
            return $this->success(['book' => $book], 200, __('books.success_save'));
        } catch (\Exception $e) {
            return $this->error(__('books.error_save'), 500);
        }
    } //end of store method

    public function update(FormData $request,$id)
    {
        try {
            $data = $request->only(keys: ['name', 'author', 'summary']);
            Book::whereId($id)->update($data);
            return $this->success([], 200, __('books.success_update'));
        } catch (\Exception $e) {
            return $this->error(__('books.error_save'), 500);
        }
    } //end of update method


    public function destroy(FormData $request,$id)
    {
        try {
            Book::whereId($id)->delete();
            return $this->success([], 200, __('books.success_destroy'));
        } catch (\Exception $e) {
            \Log::error(["message"=>$e->getMessage(),"line"=>$e->getLine()]);
            return $this->error(__('books.error_destroy'), 500);
        }
    } //end of update method
}
