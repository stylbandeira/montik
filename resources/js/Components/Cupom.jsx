import axios from 'axios';
import { useEffect, useState } from 'react';

export default function Cupom({ carrinho, cupomAplicado, setCupomAplicado }) {
    const [cupom, setCupom] = useState('');
    const [subTotalCarrinho, setSubtotalCarrinho] = useState(0);

    const handleCupom = async (e) => {
        e.preventDefault();
        try {
            // const response = await axios.post('/api/cupons/valida', {
            //     params: {
            //         codigo: cupom,
            //         subtotalPedido: subTotalCarrinho
            //     }
            // });

            const response = await axios.post('/api/cupons/valida', {
                codigo: cupom,
                subtotalPedido: parseFloat(subTotalCarrinho).toFixed(2)
            }, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            localStorage.setItem('cupomAplicado', JSON.stringify(response.data.cupom));
            setCupomAplicado(response.data.cupom);
        } catch (error) {
            if (error.response && error.response.status === 400) {
                alert(error.response.data.message);
            } else {
                alert('Erro inesperado. Tente novamente');
            }
            setCupomAplicado(null);
        }
    }

    useEffect(() => {
        const cupomGuardado = JSON.parse(localStorage.getItem('cupomAplicado'));
        setSubtotalCarrinho(carrinho.reduce((soma, produto) => soma + produto.total_parcial, 0));

        setCupomAplicado(cupomGuardado);
        setCupom(cupomGuardado?.codigo ?? '');
    }, []);

    return (
        <>
            <div className="m-2 w-100">
                <form className='w-100'>
                    <input
                        type="text"
                        className='w-100'
                        placeholder='Digite o Cupom'
                        onChange={(e) => setCupom(e.target.value)}
                        value={cupom}
                    />

                    <button
                        onClick={handleCupom}
                        className='w-100 btn btn-success mt-2'
                    >
                        Aplicar Cupom
                    </button>
                </form>
            </div>
        </>
    );
}
