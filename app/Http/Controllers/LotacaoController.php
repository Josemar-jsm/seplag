<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lotacao;
/**
 * Description of LotacaoController
 *
 * @author josemarsilva
 */
class LotacaoController extends Controller {

    public function index()
    {
        return Lotacao::with(['pessoa', 'unidade'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pes_id' => 'required|exists:pessoa,pes_id',
            'unid_id' => 'required|exists:unidade,unid_id',
            'lot_data_lotacao' => 'required|date',
            'lot_data_remocao' => 'nullable|date',
            'lot_portaria' => 'nullable|string|max:100',
        ]);

        return Lotacao::create($data);
    }

    public function show($id)
    {
        return Lotacao::with(['pessoa', 'unidade'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $lotacao = Lotacao::findOrFail($id);

        $data = $request->validate([
            'lot_data_lotacao' => 'sometimes|date',
            'lot_data_remocao' => 'nullable|date',
            'lot_portaria' => 'nullable|string|max:100',
        ]);

        $lotacao->update($data);

        return $lotacao;
    }

    public function destroy($id)
    {
        Lotacao::findOrFail($id)->delete();
        return response()->noContent();
    }
}
