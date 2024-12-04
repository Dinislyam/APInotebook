<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notebook;

/**
 * @OA\PathItem(path="/api/v1/notebook")
 */
class NotebookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/notebook",
     *     tags={"Notebook"},
     *     summary="Get all notebook entries",
     *     description="Retrieve a list of notebook entries with pagination",
     *     @OA\Response(
     *         response=200,
     *         description="A list of notebook entries",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Notebook")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        return Notebook::paginate(10); // 10 записей на страницу
    }

    /**
     * @OA\Post(
     *     path="/api/v1/notebook",
     *     tags={"Notebook"},
     *     summary="Create a new notebook entry",
     *     description="Store a new notebook entry in the database",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"full_name", "phone", "email"},
     *             @OA\Property(property="full_name", type="string", maxLength=255),
     *             @OA\Property(property="phone", type="string", maxLength=20),
     *             @OA\Property(property="email", type="string", format="email", maxLength=255),
     *             @OA\Property(property="company", type="string", maxLength=255, nullable=true),
     *             @OA\Property(property="birth_date", type="string", format="date", nullable=true),
     *             @OA\Property(property="photo", type="string", format="binary", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="The created notebook entry",
     *         @OA\JsonContent(ref="#/components/schemas/Notebook")
     *     ),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Создание записи без валидации
        $notebook = new Notebook([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'company' => $request->company,
            'birth_date' => $request->birth_date,
            'photo_path' => null,
        ]);

        // Обработка файла, если он был загружен
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $notebook->photo_path = $photo->store('photos', 'public');
        }

        // Сохранение записи
        $notebook->save();

        return response()->json($notebook, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/notebook/{id}",
     *     tags={"Notebook"},
     *     summary="Get a notebook entry by ID",
     *     description="Retrieve a notebook entry using its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the notebook entry",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The requested notebook entry",
     *         @OA\JsonContent(ref="#/components/schemas/Notebook")
     *     ),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function show($id)
    {
        $notebook = Notebook::findOrFail($id);
        return response()->json($notebook);
    }

    /**
     * @OA\Post (
     *     path="/api/v1/notebook/{id}",
     *     tags={"Notebook"},
     *     summary="Update a notebook entry",
     *     description="Update an existing notebook entry in the database",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the notebook entry",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="full_name", type="string", maxLength=255, nullable=true),
     *             @OA\Property(property="phone", type="string", maxLength=20, nullable=true),
     *             @OA\Property(property="email", type="string", format="email", maxLength=255, nullable=true),
     *             @OA\Property(property="company", type="string", maxLength=255, nullable=true),
     *             @OA\Property(property="birth_date", type="string", format="date", nullable=true),
     *             @OA\Property(property="photo", type="string", format="binary", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The updated notebook entry",
     *         @OA\JsonContent(ref="#/components/schemas/Notebook")
     *     ),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
    public function update(Request $request, $id)
    {
        $notebook = Notebook::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'photo' => 'nullable|image|max:2048',
        ]);

        $notebook->fill($validated);

        if ($request->hasFile('photo')) {
            $notebook->photo_path = $request->file('photo')->store('photos', 'public');
        }

        $notebook->save();

        return response()->json($notebook);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/notebook/{id}",
     *     tags={"Notebook"},
     *     summary="Delete a notebook entry",
     *     description="Delete a notebook entry from the database",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the notebook entry",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Notebook entry deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Notebook entry deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function destroy($id)
    {
        $notebook = Notebook::findOrFail($id);
        $notebook->delete();

        return response()->json(['message' => 'Notebook entry deleted successfully.']);
    }
}

