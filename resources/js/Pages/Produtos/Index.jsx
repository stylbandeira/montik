import { useState } from 'react';
import { Head } from '@inertiajs/react';

export default function Produtos({ produtos }) {
    const [produtoSelecionado, setProdutoSelecionado] = useState(null);
    const [variacoesSelecionadas, setVariacoesSelecionadas] = useState({});

    const handleProdutoChange = (e) => {
        const produtoId = parseInt(e.target.value);
        const produto = produtos.find(p => p.id === produtoId);
        setProdutoSelecionado(produto);
        setVariacoesSelecionadas({});
    };

    const handleOpcaoChange = (variacaoId, opcaoId) => {
        setVariacoesSelecionadas({
            ...variacoesSelecionadas,
            [variacaoId]: opcaoId
        });
    };

    const adicionarAoCarrinho = () => {
        console.log('Adicionando ao carrinho:', {
            produto: produtoSelecionado,
            variacoes: variacoesSelecionadas
        });

        // Aqui você pode fazer uma chamada axios para adicionar ao carrinho
        // axios.post('/carrinho', { ... })
    };

    return (
        <div className="container mt-5">
            <Head title="Produtos" />
            <h2>Escolha um produto</h2>

            <select className="form-select mb-3" onChange={handleProdutoChange}>
                <option value="">Selecione um produto</option>
                {produtos.map(p => (
                    <option key={p.id} value={p.id}>{p.nome}</option>
                ))}
            </select>

            {produtoSelecionado && (
                <div className="card p-4">
                    <h4>{produtoSelecionado.nome}</h4>
                    <p>{produtoSelecionado.descricao}</p>

                    {produtoSelecionado.variacoes.map(variacao => (
                        <div key={variacao.id} className="mb-3">
                            <label className="form-label">{variacao.nome_variacao}</label>
                            <select
                                className="form-select"
                                onChange={e => handleOpcaoChange(variacao.id, parseInt(e.target.value))}
                                value={variacoesSelecionadas[variacao.id] || ''}
                            >
                                <option value="">Selecione uma opção</option>
                                {variacao.opcoes.map(opcao => (
                                    <option key={opcao.id} value={opcao.id}>{opcao.valor}</option>
                                ))}
                                {console.log(variacao)}
                            </select>
                        </div>
                    ))}

                    <button className="btn btn-primary" onClick={adicionarAoCarrinho}>
                        Adicionar ao Carrinho
                    </button>
                </div>
            )}
        </div>
    );
}
