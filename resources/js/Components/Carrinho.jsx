import { useEffect, useState } from 'react';
import Frete from './Frete';

export default function Carrinho() {
    const [carrinho, setCarrinho] = useState([]);
    const [valorTotal, setValorTotal] = useState(0);

    const valorTotalFormatado = valorTotal.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });

    useEffect(() => {
        const itensSalvos = JSON.parse(localStorage.getItem('carrinho')) || [];
        setCarrinho(itensSalvos);

    }, []);

    useEffect(() => {
        const totalCarrinho = carrinho.reduce((soma, item) => {
            return soma + (parseFloat(item.total_parcial) || 0);
        }, 0);

        setValorTotal(totalCarrinho);
    });

    const handleMoneyValue = (valor) => {
        return valor.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        })
    };

    return (
        <div className="container mt-5">
            <h2 className="mb-4">Itens no Carrinho</h2>

            {carrinho.length === 0 ? (
                <div>
                    <p>Seu carrinho está vazio.</p>
                </div>
            ) : (
                <div className="">
                    <div className="list-group">

                        {carrinho.map((item, index) => (
                            < div key={index} className="list-group-item" >
                                <h5>Produto ID: {item.id_produto}</h5>
                                <h6 className='money'>{handleMoneyValue(item.valor_produto)}</h6>

                                <ul className='bg-slate-200'>
                                    {Object.entries(item.variacoes).map(([variacao, valor]) => (
                                        <li key={valor.nome_variacao}>
                                            {valor.nome_variacao}: {valor.valor}
                                        </li>
                                    ))}
                                </ul>
                                <div className="row">
                                    <div className="col-md-6">
                                        <p>Quantidade: {item.quantidade}</p>
                                    </div>

                                    <div className="col-md-6 text-end">
                                        <p className='money'><strong>Valor parcial: {handleMoneyValue(item.total_parcial)}</strong></p>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>

                    <div class="d-flex mb-3">
                        <div class="ms-auto p-2">
                            <h5><strong>Total: {handleMoneyValue(valorTotal)}</strong></h5>
                        </div>
                    </div>

                    <div className="ms-auto d-flex">
                        <Frete></Frete>
                    </div>

                    <div className="card mt-4">
                        <input type="text" name="" id="" placeholder='Digite o Cupom' />
                    </div>

                    <div className="card mt-4">
                        <button>Comprar Carrinho</button>
                    </div>
                </div>
            )
            }
        </div >
    );
}
