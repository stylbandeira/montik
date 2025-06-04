import { useEffect, useState } from 'react';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Cupons() {

    useEffect(() => {
        axios.get('api/cupons')
            .then(response => setCupons(response.data.cupons))
            .catch(error => console.error('Erro ao buscar cupons', error));
    }, []);

    const [cupons, setCupons] = useState([]);
    const [form, setForm] = useState({
        codigo: '',
        valido_ate: '',
        tipo_desconto: 'PORCENTAGEM',
        desconto: '',
        quantidade: '',
        val_minimo: '',
    });

    const handleChange = (e) => {
        const { name, value } = e.target;
        setForm((prev) => ({ ...prev, [name]: value }));
    };

    const handleSubmit = (e) => {
        form.desconto = parseFloat(form.desconto).toFixed(2);
        form.val_minimo = parseFloat(form.val_minimo).toFixed(2);

        e.preventDefault();
        const res = axios.post('api/cupons', form)
            .then(response => setCupons((prev) => [...prev, response.data.cupom]))
            .catch(error => console.error('Erro ao buscar cupons', error));

        console.log(cupons);
        console.log(res);

        // const novoCupom = {
        //     id: Date.now(),
        //     ...form,
        // };
        // setCupons((prev) => [...prev, novoCupom]);
        setForm({
            valido_ate: '',
            tipo_desconto: 'PORCENTAGEM',
            desconto: '',
            quantidade: '',
            val_minimo: '',
        });
    };

    return (
        <>
            <div className="flex gap-6 p-6">
                {/* Formulário */}
                <form
                    onSubmit={handleSubmit}
                    className="w-1/2 bg-white shadow-lg rounded-2xl p-6 space-y-4"
                >
                    <h2 className="text-xl font-bold mb-2">Criar Cupom</h2>

                    <div>
                        <label className="block text-sm font-medium mb-1">Código de Cupom</label>
                        <input
                            type="text"
                            name="codigo"
                            value={form.codigo}
                            onChange={handleChange}
                            className="w-full border rounded-lg p-2"
                            required
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium mb-1">Válido até</label>
                        <input
                            type="date"
                            name="valido_ate"
                            value={form.valido_ate}
                            onChange={handleChange}
                            className="w-full border rounded-lg p-2"
                            required
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium mb-1">Tipo de Desconto</label>
                        <select
                            name="tipo_desconto"
                            value={form.tipo_desconto}
                            onChange={handleChange}
                            className="w-full border rounded-lg p-2"
                        >
                            <option value="PORCENTAGEM">Porcentagem (%)</option>
                            <option value="VALOR">Valor (R$)</option>
                        </select>
                    </div>

                    <div>
                        <label className="block text-sm font-medium mb-1">Desconto</label>
                        <input
                            type="number"
                            name="desconto"
                            value={form.desconto}
                            onChange={handleChange}
                            className="w-full border rounded-lg p-2"
                            placeholder="Ex: 10 ou 20.50"
                            required
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium mb-1">Valor Mínimo R$:</label>
                        <input
                            type="number"
                            name="val_minimo"
                            value={form.val_minimo}
                            onChange={handleChange}
                            className="w-full border rounded-lg p-2"
                            required
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium mb-1">Quantidade de Cupons</label>
                        <input
                            type="number"
                            name="quantidade"
                            value={form.quantidade}
                            onChange={handleChange}
                            className="w-full border rounded-lg p-2"
                            required
                        />
                    </div>

                    <button
                        type="submit"
                        className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
                    >
                        Criar Cupom
                    </button>
                </form>

                {/* Lista de Cupons */}
                <div className="w-1/2 bg-gray-50 shadow-inner rounded-2xl p-6">
                    <h2 className="text-xl font-bold mb-4">Cupons Criados</h2>
                    {cupons.length === 0 ? (
                        <p className="text-gray-500">Nenhum cupom criado ainda.</p>
                    ) : (
                        <ul className="space-y-4">
                            {cupons.map((cupom) => (
                                <li key={cupom.id} className="bg-white border rounded-xl p-4">
                                    <h2>{cupom.codigo}</h2>
                                    <p><strong>Válido até:</strong> {cupom.valido_ate}</p>
                                    <p><strong>Tipo de Desconto:</strong> {cupom.tipo_desconto}</p>
                                    <p>
                                        <strong>Desconto:</strong>{' '}
                                        {cupom.tipo_desconto === 'PORCENTAGEM'
                                            ? `${cupom.desconto}%`
                                            : `R$ ${parseFloat(cupom.desconto).toFixed(2)}`}
                                    </p>
                                    <p><strong>Quantidade:</strong> {cupom.quantidade}</p>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            </div>
        </>
    );
}

Cupons.layout = page => <AuthenticatedLayout children={page} />
