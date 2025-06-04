import { useEffect, useState } from 'react';
import Frete from './Frete';
import { router } from '@inertiajs/react';

export default function Carrinho({ cart, cupomAplicado, frete, setTotalParcial, setDescontoCupom, setValorTotal, totalParcial, valorTotal, descontoCupom }) {
    const [carrinho, setCarrinho] = useState([]);
    const [carregandoCupom, setCarregandoCupom] = useState(true)

    useEffect(() => {
        const carrinho = cart;

        if (carrinho && carrinho.length > 0) {
            setCarrinho(carrinho);
        }

        carregaCupom();
    }, [cart, cupomAplicado, frete]);

    useEffect(() => {
        const carrinho = cart;

        if (carrinho && carrinho.length > 0) {
            setCarrinho(carrinho);
        }

        carregaCupom();
    });

    const carregaCupom = () => {
        const totalCarrinho = carrinho.reduce((soma, item) => {
            return soma + (parseFloat(item.total_parcial) || 0);
        }, 0);

        let desconto = 0;

        if (cupomAplicado) {
            if (cupomAplicado.tipo_desconto === 'VAL') {
                desconto = cupomAplicado.desconto;
            } else if (cupomAplicado.tipo_desconto === 'PCT') {
                desconto = totalCarrinho * cupomAplicado.desconto / 100;
            }

            setDescontoCupom(desconto);
        }

        if (cupomAplicado) {
            setTotalParcial(totalCarrinho);
            setValorTotal(totalCarrinho + frete - desconto);
        } else {
            setValorTotal(totalCarrinho + frete);
        }

        setCarregandoCupom(false);
    }

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

                    <div className="d-flex align-items-end flex-column mb-3 mt-2">
                        {cupomAplicado && !carregandoCupom ?
                            <>
                                <div>
                                    <h5>Subtotal: {handleMoneyValue(totalParcial)}</h5>
                                </div>

                                <div>
                                    <h5>Desconto: {handleMoneyValue(descontoCupom)}</h5>
                                </div>
                            </> :
                            <></>
                        }
                        {frete ?
                            <div>
                                <h5>Frete: {handleMoneyValue(frete)}</h5>
                            </div> :
                            <div>
                            </div>
                        }
                        <div >
                            <h5><strong>Total: {handleMoneyValue(valorTotal)}</strong></h5>
                        </div>
                    </div>

                </div>
            )
            }
        </div >
    );
}
