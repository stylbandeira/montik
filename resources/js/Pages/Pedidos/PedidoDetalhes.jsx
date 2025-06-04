import axios from 'axios';
import React from 'react';

const PedidoDetalhes = ({ pedido }) => {
    if (!pedido) return <p className="text-gray-500">Pedido não encontrado.</p>;

    const cancelarPedido = async () => {
        try {
            const res = await axios.delete('/pedidos/' + pedido.codigo);

            if (res.status === 404) {
                const data = await res.json();
                alert(data.message);
            }

            if (res.status === 200) {
                alert('Pedido cancelado com sucesso.');
            } else {
                alert('Problema indefinido ao cancelar pedido.');
            }


        } catch (error) {
            console.error('Erro ao cancelar pedido', error);
            alert('Ocorreu um erro ao cancelar pedido');
        }
    }

    const confirmarPedido = async () => {
        try {
            const res = await axios.put('/api/pedidos/' + pedido.id, {
                status: 'CONFIRMADO',
                pre_pedido: true
            });

            if (res.status === 404) {
                const data = await res.json();
                alert(data.message);
            }

            if (res.status === 200) {
                alert('Pedido confirmado com sucesso.');
            } else {
                alert('Problema indefinido ao confirmar pedido.');
            }


        } catch (error) {
            console.error('Erro ao confirmar pedido', error);
            alert('Ocorreu um erro ao confirmar pedido');
        }
    }

    return (
        <div className="max-w-md mx-auto bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
            <h2 className="text-xl font-bold mb-4">Pedido #{pedido.codigo || pedido.id}</h2>

            <div className="space-y-2 text-sm text-gray-700">
                <p><strong>Email:</strong> {pedido?.email}</p>
                <p><strong>Data:</strong> {new Date(pedido.created_at).toLocaleDateString()}</p>
                <p><strong>Status:</strong> {pedido.status}</p>
                <p><strong>Total:</strong> R$ {Number(pedido.total).toFixed(2)}</p>
            </div>

            {pedido.itens?.length > 0 && (
                <div className="mt-4">
                    <h3 className="font-semibold mb-2">Itens:</h3>
                    <ul className="list-disc list-inside text-sm text-gray-600">
                        {pedido.itens.map((item, index) => (
                            <li key={index}>
                                {item.nome} — {item.quantidade}x — R$ {Number(item.preco).toFixed(2)}
                            </li>
                        ))}
                    </ul>
                </div>
            )}

            {pedido.status === 'CONFIRMADO' ? (
                <></>
            ) : (
                <div className="row">
                    <button className="btn btn-danger mt-4 m-2" onClick={cancelarPedido}>Cancelar o Pedido</button>
                    <button className="btn btn-success mt-4 m-2" onClick={confirmarPedido}>Confirmar Pedido</button>
                </div>
            )
            }
        </div>
    );
};

export default PedidoDetalhes;
