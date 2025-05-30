import Carrinho from '@/Components/Carrinho';
import GuestLayout from '@/Layouts/GuestLayout';
import { router, usePage } from '@inertiajs/react';
import axios from 'axios';
import { useEffect, useState } from 'react';

export default function Comprar() {
    const [itens, setItens] = useState([]);
    const [cart, setCart] = useState([]);

    useEffect(() => {
        axios.get('api/produtos/variacoes-disponiveis')
            .then(response => {
                setItens(response.data)
            })

        const carrinhoSalvo = JSON.parse(localStorage.getItem('carrinho')) || [];
        setCart(carrinhoSalvo);
        setUuid();
    }, []);

    const setUuid = () => {
        let uuid = localStorage.getItem('uuid');

        if (!uuid) {
            uuid = crypto.randomUUID();
            localStorage.setItem('uuid', uuid);
        }
    }

    const checkout = () => {
        router.get('/pedidos');
    }

    const handleSubmit = (e, item) => {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        const produto = {
            id_produto: form.dataset.produtoId,
            variacoes: {},
            quantidade: parseInt(formData.get('quantidade')) || 1,
            valor_produto: parseFloat(item.valor_produto),
            total_parcial: parseFloat(item.valor_produto) * (parseInt(formData.get('quantidade')) || 1)
        };

        // Pega as variações selecionadas
        for (let [key, value] of formData.entries()) {
            if (key !== 'quantidade') {
                const variacaoSelecionada = JSON.parse(value);
                produto.id_produto_variacao = variacaoSelecionada.id;
                produto.variacoes[key] = {
                    id_produto_variacao: variacaoSelecionada.id,
                    valor: variacaoSelecionada.valor,
                    nome_variacao: key
                };
            }
        }
        const carrinhoAtual = [...cart, produto];
        localStorage.setItem('carrinho', JSON.stringify(carrinhoAtual));
        setCart(carrinhoAtual);

        //Remove os itens do carrinho -- REMOVER AO FIM
        // localStorage.setItem('carrinho', JSON.stringify([]));

        alert('Produto adicionado ao carrinho!');
    };

    return <>
        <div className="row">
            <div className="col-md-6">
                <h1>Compra</h1>

                {itens.map((item) => (
                    <div>
                        <div className="card shadow-sm p-4 mb-4">
                            <h2 className="mb-3">{item.nome_produto}</h2>
                            <p className="text-muted">{item.descricao_produto}</p>
                            <p className="text-muted" key="valor_produto" value={item.valor_produto}>R$: {item.valor_produto}</p>

                            <form onSubmit={(e) => handleSubmit(e, item)} className="mt-4" data-produto-id={item.id_produto}>
                                <div className="row g-3">
                                    {Object.entries(item.variacoes_disponiveis).map(([nome_variacao, opcoes]) => (
                                        <div className="col-md-6" key={nome_variacao}>
                                            <label htmlFor={nome_variacao} className="form-label">{nome_variacao}</label>
                                            <select className="form-select" id={nome_variacao} name={nome_variacao}>
                                                <option value="">Selecione {nome_variacao}</option>
                                                {opcoes.map((opcao) => (
                                                    <option key={opcao.id_produto_variacao} value={JSON.stringify({
                                                        id: opcao.id_produto_variacao,
                                                        valor: opcao.valor
                                                    })}>
                                                        {opcao.valor}
                                                    </option>
                                                ))}
                                            </select>
                                        </div>
                                    ))}
                                </div>

                                <hr />

                                <div className="row align-items-center mb-3">
                                    <div className="col-md-3">
                                        <label htmlFor="quantidade" className="form-label mb-0">Quantidade:</label>
                                    </div>
                                    <div className="col-md-3">
                                        <input
                                            type="number"
                                            className="form-control"
                                            id="quantidade"
                                            name="quantidade"
                                            min="1"
                                            defaultValue="0"
                                        />
                                    </div>
                                    <div className="col-md-3">

                                    </div>

                                    <div className="col-md-3">
                                        <button type="submit">Adicionar ao Carrinho</button>
                                    </div>
                                </div>

                            </form>
                        </div >
                    </div >
                ))
                }
            </div>
            <div className="col-md-6 card">
                <div className="sticky-cart">
                    <Carrinho cart={cart}></Carrinho>
                    <button className='btn btn-success w-100' onClick={checkout}>Continuar para checkout</button>
                </div>
            </div>
        </div>

    </>;
}

Comprar.layout = (page) => <GuestLayout children={page} />;
